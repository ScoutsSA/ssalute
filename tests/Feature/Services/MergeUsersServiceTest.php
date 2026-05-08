<?php

namespace Tests\Feature\Services;

use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use App\Services\UserServices\MergeUsersService;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class MergeUsersServiceTest extends SdCoreTestCase
{
    #[Test]
    public function it_rewrites_references_from_source_to_target(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->connection()->table('system_users_email_verifications')->insert([
            'userID' => $source->id,
            'emailAddress' => 'a@example.com',
        ]);
        $this->connection()->table('notifications')->insert([
            'userID' => $source->id,
            'groupID' => 0,
            'districtID' => 0,
            'regionID' => 0,
            'countryID' => 0,
            'title' => 't',
            'description' => 'd',
            'extended' => '',
            'colour' => '',
            'active' => 1,
            'doNotShowBefore' => '2024-01-01',
            'doNotShowAfter' => '2099-01-01',
            'forType' => 0,
            'created' => now(),
            'createdby' => $source->id,
            'shown' => 0,
        ]);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $this->assertGreaterThanOrEqual(2, $result['rows_merged']);
        $this->assertSame(0, $result['rows_skipped']);

        $this->assertSame(1, $this->connection()
            ->table('system_users_email_verifications')
            ->where('userID', $target->id)
            ->count());

        $this->assertSame(0, $this->connection()
            ->table('system_users_email_verifications')
            ->where('userID', $source->id)
            ->count());

        $this->assertSame(1, $this->connection()
            ->table('notifications')
            ->where('userID', $target->id)
            ->count());
    }

    #[Test]
    public function it_demotes_duplicate_primary_roles_after_merge(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();
        $roleType = \App\Models\SystemUserType::factory()->create();

        $olderPrimaryId = $this->connection()->table('system_users_other_roles')->insertGetId([
            'userID' => $target->id,
            'roleID' => $roleType->id,
            'defaultRole' => 1,
            'active' => 1,
            'created' => now()->subYear(),
            'createdby' => $target->id,
        ]);
        $newerPrimaryId = $this->connection()->table('system_users_other_roles')->insertGetId([
            'userID' => $source->id,
            'roleID' => $roleType->id,
            'defaultRole' => 1,
            'active' => 1,
            'created' => now(),
            'createdby' => $source->id,
        ]);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $this->assertContains($olderPrimaryId, $result['demoted_role_ids']);
        $this->assertNotContains($newerPrimaryId, $result['demoted_role_ids']);

        $primaryCount = $this->connection()
            ->table('system_users_other_roles')
            ->where('userID', $target->id)
            ->where('defaultRole', 1)
            ->count();
        $this->assertSame(1, $primaryCount);

        $this->assertSame(1, $this->connection()
            ->table('system_users_other_roles')
            ->where('id', $newerPrimaryId)
            ->where('defaultRole', 1)
            ->count());
    }

    #[Test]
    public function it_does_not_touch_roles_when_only_one_primary_exists(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();
        $roleType = \App\Models\SystemUserType::factory()->create();

        $this->connection()->table('system_users_other_roles')->insert([
            'userID' => $source->id,
            'roleID' => $roleType->id,
            'defaultRole' => 1,
            'active' => 1,
            'created' => now(),
            'createdby' => $source->id,
        ]);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $this->assertSame([], $result['demoted_role_ids']);
        $this->assertSame(1, $this->connection()
            ->table('system_users_other_roles')
            ->where('userID', $target->id)
            ->where('defaultRole', 1)
            ->count());
    }

    #[Test]
    public function it_appends_a_merge_note_to_target_general_notes(): void
    {
        $source = SystemUser::factory()->create([
            'first_name' => 'Source',
            'surname' => 'McSourceface',
            'username' => 'src@example.com',
        ]);
        $target = SystemUser::factory()->create([
            'generalNotes' => 'Existing note line.',
        ]);

        $this->service()->merge($source->id, $target->id, performedBy: 99);

        $notes = $this->connection()->table('system_users')->where('id', $target->id)->value('generalNotes');
        $this->assertStringContainsString('Existing note line.', $notes);
        $this->assertStringContainsString("Merged in user #{$source->id}", $notes);
        $this->assertStringContainsString('Source McSourceface', $notes);
        $this->assertStringContainsString('src@example.com', $notes);
        $this->assertStringContainsString('admin #99', $notes);
    }

    #[Test]
    public function polymorphic_match_does_not_touch_unrelated_user_named_models(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        // Audit row whose `auditable_type` contains the substring "User" but is
        // NOT a SystemUser (would be silently corrupted by a LIKE '%User%' match).
        $strayId = $this->connection()->table('ssalute_audits')->insertGetId([
            'user_type' => SystemUser::class,
            'user_id' => 1,
            'event' => 'updated',
            'auditable_type' => \App\Models\SystemUserType::class,
            'auditable_id' => $source->id,
            'old_values' => '{}',
            'new_values' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->service()->merge($source->id, $target->id, performedBy: 1);

        $stray = $this->connection()->table('ssalute_audits')->where('id', $strayId)->first();
        $this->assertSame($source->id, (int) $stray->auditable_id, 'SystemUserType audit row must not be touched by a user merge.');
    }

    #[Test]
    public function it_writes_an_audit_row_for_the_merge(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->service()->merge($source->id, $target->id, performedBy: 99);

        $audit = $this->connection()
            ->table('ssalute_audits')
            ->where('event', 'merged')
            ->where('auditable_type', SystemUser::class)
            ->where('auditable_id', $target->id)
            ->first();

        $this->assertNotNull($audit);
        $this->assertSame(99, (int) $audit->user_id);

        $newValues = json_decode($audit->new_values, true);
        $this->assertSame($source->id, $newValues['merged_from_user_id']);
        $this->assertArrayHasKey('snapshot_path', $newValues);
    }

    #[Test]
    public function it_deletes_the_source_user_after_merge(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->service()->merge($source->id, $target->id, performedBy: 1);

        $this->assertSame(0, $this->connection()
            ->table('system_users')
            ->where('id', $source->id)
            ->count());
        $this->assertSame(1, $this->connection()
            ->table('system_users')
            ->where('id', $target->id)
            ->count());
    }

    #[Test]
    public function preview_reports_unique_constraint_conflicts_and_merge_skips_them(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->connection()->table('membership_certificates')->insert([
            'uuid' => (string) Str::uuid(),
            'user_id' => $source->id,
            'visible_fields' => '[]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->connection()->table('membership_certificates')->insert([
            'uuid' => (string) Str::uuid(),
            'user_id' => $target->id,
            'visible_fields' => '[]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $preview = $this->service()->preview($source->id, $target->id);
        $conflictTables = array_column($preview['conflicts'], 'table');

        $this->assertContains('membership_certificates', $conflictTables);
        $this->assertSame(1, $preview['totals']['rows_to_skip']);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $this->assertSame(1, $result['rows_skipped']);
        $this->assertSame(1, $this->connection()
            ->table('membership_certificates')
            ->where('user_id', $source->id)
            ->count());
        $this->assertSame(1, $this->connection()
            ->table('membership_certificates')
            ->where('user_id', $target->id)
            ->count());
    }

    #[Test]
    public function preview_includes_a_table_when_only_source_has_rows_with_unique_column(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->connection()->table('membership_certificates')->insert([
            'uuid' => (string) Str::uuid(),
            'user_id' => $source->id,
            'visible_fields' => '[]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $preview = $this->service()->preview($source->id, $target->id);
        $mergeableTables = array_column($preview['mergeable'], 'table');

        $this->assertContains('membership_certificates', $mergeableTables);
        $this->assertSame([], $preview['conflicts']);
    }

    #[Test]
    public function it_fills_target_columns_that_are_null_from_source(): void
    {
        $source = SystemUser::factory()->create([
            'first_name' => 'SourceFirst',
            'surname' => 'SourceSurname',
            'idNumber' => '1234567890123',
        ]);
        $target = SystemUser::factory()->create([
            'first_name' => 'TargetFirst',
            'surname' => null,
            'idNumber' => null,
        ]);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $target->refresh();
        $this->assertSame('TargetFirst', $target->first_name);
        $this->assertSame('SourceSurname', $target->surname);
        $this->assertSame('1234567890123', $target->idNumber);
        $this->assertArrayHasKey('surname', $result['columns_filled']);
        $this->assertArrayHasKey('idNumber', $result['columns_filled']);
        $this->assertArrayNotHasKey('first_name', $result['columns_filled']);
    }

    #[Test]
    public function gap_fill_never_touches_skip_list_columns(): void
    {
        $source = SystemUser::factory()->create(['username' => 'source@example.com']);
        $target = SystemUser::factory()->create(['username' => 'target@example.com']);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $target->refresh();
        $this->assertSame('target@example.com', $target->username);
        $this->assertArrayNotHasKey('username', $result['columns_filled']);
        $this->assertArrayNotHasKey('id', $result['columns_filled']);
    }

    #[Test]
    public function preview_lists_unmerged_columns_when_target_already_has_value(): void
    {
        $source = SystemUser::factory()->create([
            'first_name' => 'SourceFirst',
            'idNumber' => '111',
        ]);
        $target = SystemUser::factory()->create([
            'first_name' => 'TargetFirst',
            'idNumber' => '222',
        ]);

        $preview = $this->service()->preview($source->id, $target->id);
        $byColumn = array_column($preview['unmerged_columns'], null, 'column');

        $this->assertArrayHasKey('first_name', $byColumn);
        $this->assertSame('SourceFirst', $byColumn['first_name']['source_value']);
        $this->assertSame('TargetFirst', $byColumn['first_name']['target_value']);
        $this->assertStringContainsString('target', $byColumn['first_name']['reason']);
        $this->assertArrayHasKey('idNumber', $byColumn);
    }

    #[Test]
    public function preview_omits_columns_where_source_and_target_have_the_same_value(): void
    {
        $source = SystemUser::factory()->create([
            'first_name' => 'Alex',
            'idNumber' => '111',
        ]);
        $target = SystemUser::factory()->create([
            'first_name' => 'Alex',
            'idNumber' => '222',
        ]);

        $preview = $this->service()->preview($source->id, $target->id);
        $byColumn = array_column($preview['unmerged_columns'], null, 'column');

        $this->assertArrayNotHasKey('first_name', $byColumn);
        $this->assertArrayHasKey('idNumber', $byColumn);
    }

    #[Test]
    public function preview_lists_unmerged_columns_for_skip_list_fields(): void
    {
        $source = SystemUser::factory()->create(['username' => 'source@example.com']);
        $target = SystemUser::factory()->create(['username' => 'target@example.com']);

        $preview = $this->service()->preview($source->id, $target->id);
        $byColumn = array_column($preview['unmerged_columns'], null, 'column');

        $this->assertArrayHasKey('username', $byColumn);
        $this->assertStringContainsString('never copied', $byColumn['username']['reason']);
    }

    #[Test]
    public function preview_includes_columns_to_fill(): void
    {
        $source = SystemUser::factory()->create(['idNumber' => '1234567890123']);
        $target = SystemUser::factory()->create(['idNumber' => null]);

        $preview = $this->service()->preview($source->id, $target->id);

        $this->assertArrayHasKey('idNumber', $preview['columns_to_fill']);
        $this->assertSame('1234567890123', $preview['columns_to_fill']['idNumber']);
        $this->assertSame(1, $preview['totals']['columns_to_fill']);
    }

    #[Test]
    public function merge_writes_a_pre_merge_snapshot_file(): void
    {
        Storage::fake('local');

        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->connection()->table('system_users_email_verifications')->insert([
            'userID' => $source->id,
            'emailAddress' => 'a@example.com',
        ]);

        $result = $this->service()->merge($source->id, $target->id, performedBy: 1);

        $this->assertArrayHasKey('snapshot_path', $result);
        Storage::disk('local')->assertExists($result['snapshot_path']);

        $payload = json_decode(Storage::disk('local')->get($result['snapshot_path']), true);
        $this->assertSame($source->id, $payload['source_user_id']);
        $this->assertSame($target->id, $payload['target_user_id']);
        $this->assertSame(1, $payload['performed_by']);
        $this->assertNotNull($payload['source_user']);
        $this->assertNotNull($payload['target_user']);
        $this->assertArrayHasKey('system_users_email_verifications', $payload['data']);
        $this->assertSame('a@example.com', $payload['data']['system_users_email_verifications'][0]['emailAddress']);
    }

    #[Test]
    public function it_throws_when_source_and_target_are_the_same(): void
    {
        $user = SystemUser::factory()->create();

        $this->expectException(InvalidArgumentException::class);
        $this->service()->merge($user->id, $user->id);
    }

    #[Test]
    public function get_merge_preview_as_filament_info_list_returns_components(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->connection()->table('system_users_email_verifications')->insert([
            'userID' => $source->id,
            'emailAddress' => 'test@example.com',
        ]);

        $components = $this->service()->getMergePreviewAsFilamentInfoList($source->id, $target->id, $source, $target);

        $this->assertNotEmpty($components);
        $this->assertInstanceOf(Grid::class, $components[0]);
        $this->assertInstanceOf(TextEntry::class, $components[1]);

        $hasMergeableSection = collect($components)
            ->contains(fn ($c) => $c instanceof Section && $c->getHeading() === 'Will be merged');
        $this->assertTrue($hasMergeableSection);
    }

    #[Test]
    public function get_merge_preview_as_filament_info_list_includes_conflicts_section_when_relevant(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $this->connection()->table('membership_certificates')->insert([
            'uuid' => (string) Str::uuid(),
            'user_id' => $source->id,
            'visible_fields' => '[]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $this->connection()->table('membership_certificates')->insert([
            'uuid' => (string) Str::uuid(),
            'user_id' => $target->id,
            'visible_fields' => '[]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $components = $this->service()->getMergePreviewAsFilamentInfoList($source->id, $target->id, $source, $target);

        $hasConflictsSection = collect($components)
            ->contains(fn ($c) => $c instanceof Section && $c->getHeading() === 'Will NOT be merged');
        $this->assertTrue($hasConflictsSection);
    }

    #[Test]
    public function preview_runs_cleanly_when_source_has_minimal_references(): void
    {
        $source = SystemUser::factory()->create();
        $target = SystemUser::factory()->create();

        $preview = $this->service()->preview($source->id, $target->id);

        $this->assertSame([], $preview['conflicts']);
        $this->assertSame(0, $preview['totals']['rows_to_skip']);

        foreach ($preview['mergeable'] as $row) {
            $this->assertGreaterThan(0, $row['count']);
        }
    }

    private function service(): MergeUsersService
    {
        return new MergeUsersService;
    }

    private function connection()
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }
}
