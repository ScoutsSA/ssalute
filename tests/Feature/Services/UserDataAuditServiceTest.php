<?php

namespace Tests\Feature\Services;

use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use App\Services\UserServices\UserDataAuditService;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class UserDataAuditServiceTest extends SdCoreTestCase
{
    #[Test]
    public function it_finds_the_user_themselves(): void
    {
        $user = SystemUser::factory()->create();

        $results = (new UserDataAuditService)->audit($user->id);

        $tables = array_column($results, 'table');
        $this->assertContains('system_users', $tables);
    }

    #[Test]
    public function it_finds_records_that_reference_the_user_via_user_id_column(): void
    {
        $user = SystemUser::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('system_users_email_verifications')
            ->insert([
                'userID' => $user->id,
                'emailAddress' => 'test@example.com',
            ]);

        $results = (new UserDataAuditService)->audit($user->id);
        $byTable = array_column($results, null, 'table');

        $this->assertArrayHasKey('system_users_email_verifications', $byTable);
        $this->assertSame(1, $byTable['system_users_email_verifications']['count']);
        $this->assertCount(1, $byTable['system_users_email_verifications']['rows']);
        $this->assertSame('notification', $byTable['system_users_email_verifications']['category']);
        $this->assertStringContainsString('test@example.com', $byTable['system_users_email_verifications']['rows'][0]['label']);
    }

    #[Test]
    public function it_excludes_tables_with_no_references(): void
    {
        $user = SystemUser::factory()->create();

        $results = (new UserDataAuditService)->audit($user->id);
        $tables = array_column($results, 'table');

        $this->assertNotContains('commerce_cart', $tables);
        $this->assertNotContains('jamboree_application', $tables);
    }

    #[Test]
    public function it_returns_empty_for_unknown_user_id(): void
    {
        $results = (new UserDataAuditService)->audit(999999999);

        $this->assertSame([], $results);
    }

    #[Test]
    public function role_records_resolve_role_and_scope_names(): void
    {
        $user = SystemUser::factory()->create();
        $connection = DB::connection(AppServiceProvider::DB_SD_CORE);

        $roleType = \App\Models\SystemUserType::factory()->create(['name' => 'Cub Pack Scouter']);

        $connection->table('system_users_other_roles')->insert([
            'userID' => $user->id,
            'roleID' => $roleType->id,
            'active' => 1,
            'created' => now(),
            'createdby' => $user->id,
            'modified' => now(),
            'modifiedby' => $user->id,
        ]);

        $results = (new UserDataAuditService)->audit($user->id);
        $byTable = array_column($results, null, 'table');

        $this->assertArrayHasKey('system_users_other_roles', $byTable);
        $label = $byTable['system_users_other_roles']['rows'][0]['label'];
        $this->assertStringContainsString('Cub Pack Scouter', $label);
        $this->assertStringContainsString('active', $label);
    }

    #[Test]
    public function ams_documents_label_uses_description(): void
    {
        $user = SystemUser::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('ams_documents')
            ->insert([
                'countryID' => 196,
                'userID' => $user->id,
                'assocToRegion' => 0,
                'assocToGroup' => 0,
                'assocToDistrict' => 0,
                'documentTypeID' => 0,
                'description' => 'Police Clearance 2025',
                'PDFLocation' => '/storage/legacy/abc.pdf',
                'active' => 1,
                'created' => now(),
                'createdby' => $user->id,
                'modified' => now(),
                'modifiedby' => $user->id,
            ]);

        $results = (new UserDataAuditService)->audit($user->id);
        $byTable = array_column($results, null, 'table');

        $this->assertArrayHasKey('ams_documents', $byTable);
        $this->assertStringContainsString('Police Clearance 2025', $byTable['ams_documents']['rows'][0]['label']);
    }

    #[Test]
    public function get_audit_as_filament_info_list_returns_schema_components(): void
    {
        $user = SystemUser::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('system_users_email_verifications')
            ->insert([
                'userID' => $user->id,
                'emailAddress' => 'test@example.com',
            ]);

        $components = (new UserDataAuditService)->getAuditAsFilamentInfoList($user->id);

        $this->assertNotEmpty($components);
        $this->assertInstanceOf(TextEntry::class, $components[0]);
        $this->assertInstanceOf(Tabs::class, $components[1]);
    }

    #[Test]
    public function get_audit_as_filament_info_list_returns_empty_state_when_no_data(): void
    {
        $components = (new UserDataAuditService)->getAuditAsFilamentInfoList(999999999);

        $this->assertCount(1, $components);
        $this->assertInstanceOf(TextEntry::class, $components[0]);
    }

    #[Test]
    public function logs_are_grouped_into_log_category(): void
    {
        $user = SystemUser::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('system_user_logging')
            ->insert([
                'userID' => $user->id,
                'page' => '/some/page',
                'IP' => '127.0.0.1',
                'created' => now(),
            ]);

        $results = (new UserDataAuditService)->audit($user->id);
        $byTable = array_column($results, null, 'table');

        $this->assertArrayHasKey('system_user_logging', $byTable);
        $this->assertSame('log', $byTable['system_user_logging']['category']);
    }
}
