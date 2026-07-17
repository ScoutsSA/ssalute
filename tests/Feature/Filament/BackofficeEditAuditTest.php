<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\Users\RelationManagers\UserRoleAttachmentsRelationManager;
use App\Models\Audit;
use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * Proves the reconciliation actions the role-location audit points admins at are audit-tracked: changing a
 * user's home location and changing a role attachment's area both write an audit record attributed to the
 * acting admin.
 */
class BackofficeEditAuditTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /**
     * The full EditUser Livewire page is too heavy to mount in a test (documented 800-field memory issue),
     * so this exercises the same Eloquent update the page performs, under an authenticated admin, and
     * asserts the audit trail captures the change and the actor.
     */
    #[Test]
    public function editing_a_users_home_location_records_an_audit_attributed_to_the_admin(): void
    {
        $this->actingAs($this->superAdmin);

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);

        $user->update(['assoc_to_group' => 200]);

        $audit = Audit::query()
            ->where('auditable_type', SystemUser::class)
            ->where('auditable_id', $user->id)
            ->where('event', 'updated')
            ->latest('id')
            ->first();

        $this->assertNotNull($audit, 'Editing a user should write an audit record.');
        $this->assertSame($this->superAdmin->id, $audit->user_id);
        $this->assertSame(100, (int) $audit->old_values['assoc_to_group']);
        $this->assertSame(200, (int) $audit->new_values['assoc_to_group']);
    }

    /**
     * The role-attachments relation manager's EditAction performs `$record->update($data)`; auditing fires
     * on the model's Eloquent events, so this asserts the same update, under an authenticated admin, is
     * captured in the audit trail. The relation manager is confirmed reachable by the admin separately.
     */
    #[Test]
    public function editing_a_role_attachments_area_is_audited(): void
    {
        $this->actingAs($this->superAdmin);

        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $roleType = SystemUserType::factory()->group()->create();
        $attachment = SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType($roleType)
            ->create(['groupID' => 200]);

        $attachment->update(['groupID' => 100]);

        $audit = Audit::query()
            ->where('auditable_type', SystemUsersOtherRole::class)
            ->where('auditable_id', $attachment->id)
            ->where('event', 'updated')
            ->latest('id')
            ->first();

        $this->assertNotNull($audit, 'Editing a role attachment should write an audit record.');
        $this->assertSame($this->superAdmin->id, $audit->user_id);
        $this->assertSame(200, (int) $audit->old_values['groupID']);
        $this->assertSame(100, (int) $audit->new_values['groupID']);
    }

    #[Test]
    public function the_role_attachments_relation_manager_is_reachable_by_an_admin(): void
    {
        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $attachment = SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType(SystemUserType::factory()->group()->create())
            ->create(['groupID' => 200]);

        Livewire::actingAs($this->superAdmin)
            ->test(UserRoleAttachmentsRelationManager::class, [
                'ownerRecord' => $user,
                'pageClass' => ViewUser::class,
            ])
            ->set('activeTab', 'active')
            ->assertCanSeeTableRecords([$attachment]);
    }

    #[Test]
    public function role_attachments_can_be_edited_and_deleted_from_the_view_page(): void
    {
        $user = SystemUser::factory()->create(['assoc_to_group' => 100]);
        $attachment = SystemUsersOtherRole::factory()
            ->forUser($user)
            ->ofType(SystemUserType::factory()->group()->create())
            ->create(['groupID' => 200]);

        $component = Livewire::actingAs($this->superAdmin)
            ->test(UserRoleAttachmentsRelationManager::class, [
                'ownerRecord' => $user,
                'pageClass' => ViewUser::class,
            ])
            ->set('activeTab', 'active');

        $this->assertFalse(
            $component->instance()->isReadOnly(),
            'The role-attachments relation manager should be editable on the View page.'
        );

        $component
            ->assertTableActionVisible('edit', $attachment)
            ->assertTableActionVisible('delete', $attachment);
    }
}
