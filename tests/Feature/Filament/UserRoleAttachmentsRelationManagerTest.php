<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\RelationManagers\UserRoleAttachmentsRelationManager;
use App\Models\Region;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * The legacy `system_users_other_roles` table declares its scope columns `NOT NULL DEFAULT 0`, and the
 * BackOffice role form posts null for a scope left as "None". These tests reproduce the production
 * failure (ticket 008) and pin the legacy zero convention on every write path.
 */
class UserRoleAttachmentsRelationManagerTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    private SystemUser $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();

        $this->member = SystemUser::factory()->create();
    }

    #[Test]
    public function a_national_role_can_be_attached_with_every_scope_left_as_none(): void
    {
        $nationalRole = SystemUserType::factory()->create(['nationalRole' => 1, 'active' => 1]);

        $this->relationManager()
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'roleID' => $nationalRole->id,
                'regionID' => null,
                'districtID' => null,
                'groupID' => null,
                'creationNotes' => null,
            ])
            ->assertHasNoFormErrors()
            ->assertNotified();

        $attachment = $this->member->roleAttachments()->sole();

        $this->assertSame($nationalRole->id, $attachment->roleID);
        $this->assertSame(0, $attachment->regionID);
        $this->assertSame(0, $attachment->districtID);
        $this->assertSame(0, $attachment->groupID);
        $this->assertSame(SystemUsersOtherRole::DEFAULT_COUNTRY_ID, $attachment->countryID);
        $this->assertSame($this->superAdmin->id, $attachment->createdby);
    }

    #[Test]
    public function a_regional_role_stores_zero_for_the_lower_levels_and_mirrors_the_action_scope(): void
    {
        $regionalRole = SystemUserType::factory()->create(['regionalRole' => 1, 'active' => 1]);
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);

        $this->relationManager()
            ->callAction(TestAction::make(CreateAction::class)->table(), [
                'roleID' => $regionalRole->id,
                'regionID' => $region->id,
                'districtID' => null,
                'groupID' => null,
            ])
            ->assertHasNoFormErrors();

        $attachment = $this->member->roleAttachments()->sole();

        $this->assertSame($region->id, $attachment->regionID);
        $this->assertSame(0, $attachment->districtID);
        $this->assertSame(0, $attachment->groupID);
        $this->assertSame(SystemUsersOtherRole::DEFAULT_COUNTRY_ID, $attachment->actionCountryID);
        $this->assertSame($region->id, $attachment->actionRegionID);
        $this->assertSame(0, $attachment->actionDistrictID);
        $this->assertSame(0, $attachment->actionGroupID);
    }

    #[Test]
    public function clearing_a_scope_on_edit_stores_zero(): void
    {
        $attachment = SystemUsersOtherRole::factory()
            ->forUser($this->member)
            ->ofType(SystemUserType::factory()->group()->create())
            ->create(['regionID' => 5, 'districtID' => 7, 'groupID' => 9]);

        $this->relationManager()
            ->callAction(TestAction::make(EditAction::class)->table($attachment), [
                'regionID' => null,
                'districtID' => null,
                'groupID' => null,
            ])
            ->assertHasNoFormErrors();

        $attachment->refresh();

        $this->assertSame(0, $attachment->regionID);
        $this->assertSame(0, $attachment->districtID);
        $this->assertSame(0, $attachment->groupID);
    }

    #[Test]
    public function the_edit_form_shows_none_for_a_zero_scope(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $attachment = SystemUsersOtherRole::factory()
            ->forUser($this->member)
            ->ofType(SystemUserType::factory()->create(['regionalRole' => 1, 'active' => 1]))
            ->create(['regionID' => $region->id, 'districtID' => 0, 'groupID' => 0]);

        $this->relationManager()
            ->mountAction(TestAction::make(EditAction::class)->table($attachment))
            ->assertSchemaStateSet(function (array $state) use ($region): array {
                $this->assertNull($state['districtID'], 'A zero district must hydrate as the "None" placeholder.');
                $this->assertNull($state['groupID'], 'A zero group must hydrate as the "None" placeholder.');

                return ['regionID' => $region->id];
            }, 'mountedActionSchema0');
    }

    #[Test]
    public function the_model_coerces_null_legacy_columns_on_every_write_path(): void
    {
        $attachment = SystemUsersOtherRole::factory()->create([
            'regionID' => null,
            'districtID' => null,
            'groupID' => null,
            'defaultRole' => null,
            'retired' => null,
        ]);

        $attachment->refresh();

        $this->assertSame(0, $attachment->regionID);
        $this->assertSame(0, $attachment->districtID);
        $this->assertSame(0, $attachment->groupID);
        $this->assertSame(0, $attachment->defaultRole);
        $this->assertSame(0, $attachment->retired);
    }

    #[Test]
    public function explicit_action_scope_values_are_not_overwritten_on_create(): void
    {
        $attachment = SystemUsersOtherRole::factory()->create([
            'groupID' => 9,
            'actionGroupID' => 11,
        ]);

        $attachment->refresh();

        $this->assertSame(9, $attachment->groupID);
        $this->assertSame(11, $attachment->actionGroupID);
    }

    private function relationManager(): Testable
    {
        return Livewire::actingAs($this->superAdmin)
            ->test(UserRoleAttachmentsRelationManager::class, [
                'ownerRecord' => $this->member,
                'pageClass' => ViewUser::class,
            ]);
    }
}
