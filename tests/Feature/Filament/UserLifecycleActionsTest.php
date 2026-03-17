<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Models\AmsAdultLeaderMove;
use App\Models\AmsResignLeader;
use App\Models\AmsResignReason;
use App\Models\AmsRetireLeader;
use App\Models\AmsRetireReason;
use App\Models\AmsSuspendLeader;
use App\Models\AmsSuspendReason;
use App\Models\AmsTerminateLeader;
use App\Models\AmsTerminateReason;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemUser;
use App\Models\SystemUserType;
use App\Settings\GeneralSettings;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class UserLifecycleActionsTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    private SystemUser $member;

    private AmsResignReason $resignReason;

    private AmsRetireReason $retireReason;

    private AmsSuspendReason $suspendReason;

    private AmsTerminateReason $terminateReason;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
        $this->member = SystemUser::factory()->withRole()->create(['active' => 1, 'canLogon' => 1]);

        $this->resignReason = AmsResignReason::create(['reason' => 'Test Resign Reason', 'countryID' => 196]);
        $this->retireReason = AmsRetireReason::create(['reason' => 'Test Retire Reason', 'countryID' => 196]);
        $this->suspendReason = AmsSuspendReason::create(['reason' => 'Test Suspend Reason', 'countryID' => 196]);
        $this->terminateReason = AmsTerminateReason::create(['reason' => 'Test Terminate Reason', 'countryID' => 196]);
    }

    #[Test]
    public function resign_action_creates_record_and_deactivates_member(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('resign')
            ->callAction('resign', data: [
                'resignDate' => '2026-03-16',
                'resignReasonID' => $this->resignReason->id,
            ])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertDatabaseHas(AmsResignLeader::class, [
            'userID' => $this->member->id,
            'resignDate' => '2026-03-16',
            'resignReasonID' => $this->resignReason->id,
        ]);

        $this->member->refresh();
        $this->assertEquals(0, $this->member->active);
        $this->assertEquals(0, $this->member->canLogon);

        $roleAttachment = $this->member->roleAttachments()->first();
        $this->assertEquals(0, $roleAttachment->active);
        $this->assertEquals(1, $roleAttachment->resigned);
    }

    #[Test]
    public function retire_action_creates_record_and_deactivates_member(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('retire')
            ->callAction('retire', data: [
                'retiredDate' => '2026-03-16',
                'retiredReasonID' => $this->retireReason->id,
            ])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertDatabaseHas(AmsRetireLeader::class, [
            'userID' => $this->member->id,
            'retiredDate' => '2026-03-16',
            'retiredReasonID' => $this->retireReason->id,
        ]);

        $this->member->refresh();
        $this->assertEquals(0, $this->member->active);

        $roleAttachment = $this->member->roleAttachments()->first();
        $this->assertEquals(0, $roleAttachment->active);
        $this->assertEquals(1, $roleAttachment->retired);
    }

    #[Test]
    public function suspend_action_creates_record_and_marks_roles_suspended(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('suspend')
            ->callAction('suspend', data: [
                'suspendDate' => '2026-03-16',
                'suspenReasonID' => $this->suspendReason->id,
            ])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertDatabaseHas(AmsSuspendLeader::class, [
            'userID' => $this->member->id,
            'suspendDate' => '2026-03-16',
            'suspenReasonID' => $this->suspendReason->id,
        ]);

        $this->member->refresh();
        $this->assertEquals(0, $this->member->canLogon);

        $roleAttachment = $this->member->roleAttachments()->first();
        $this->assertEquals(1, $roleAttachment->suspended);
    }

    #[Test]
    public function unsuspend_action_clears_suspension(): void
    {
        // First suspend the member
        $this->member->activeRoleAttachments()->update(['suspended' => 1]);
        $this->member->update(['canLogon' => 0]);

        AmsSuspendLeader::create([
            'userID' => $this->member->id,
            'suspendDate' => '2026-03-01',
            'suspenReasonID' => $this->suspendReason->id,
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'created' => now(),
            'createdby' => $this->superAdmin->id,
        ]);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('unsuspend')
            ->callAction('unsuspend')
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->member->refresh();
        $this->assertEquals(1, $this->member->canLogon);

        $roleAttachment = $this->member->roleAttachments()->first();
        $this->assertEquals(0, $roleAttachment->suspended);

        $suspension = AmsSuspendLeader::where('userID', $this->member->id)->first();
        $this->assertNotNull($suspension->unsuspendDate);
        $this->assertEquals($this->superAdmin->id, $suspension->unsuspendedby);
    }

    #[Test]
    public function terminate_action_creates_record_and_fully_deactivates(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('terminate')
            ->callAction('terminate', data: [
                'terminateDate' => '2026-03-16',
                'terminateReasonID' => $this->terminateReason->id,
            ])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertDatabaseHas(AmsTerminateLeader::class, [
            'userID' => $this->member->id,
            'terminateDate' => '2026-03-16',
            'terminateReasonID' => $this->terminateReason->id,
        ]);

        $this->member->refresh();
        $this->assertEquals(0, $this->member->active);
        $this->assertEquals(0, $this->member->canLogon);

        $roleAttachment = $this->member->roleAttachments()->first();
        $this->assertEquals(0, $roleAttachment->active);
    }

    #[Test]
    public function activate_action_reactivates_inactive_member(): void
    {
        $this->member->update(['active' => 0, 'canLogon' => 0, 'dateDeactivated' => now()]);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('activate')
            ->callAction('activate')
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->member->refresh();
        $this->assertEquals(1, $this->member->active);
        $this->assertEquals(1, $this->member->canLogon);
        $this->assertNull($this->member->dateDeactivated);
    }

    #[Test]
    public function lifecycle_actions_hidden_for_inactive_members(): void
    {
        $this->member->update(['active' => 0]);

        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionHidden('resign')
            ->assertActionHidden('retire')
            ->assertActionHidden('suspend')
            ->assertActionHidden('terminate')
            ->assertActionVisible('activate');
    }

    #[Test]
    public function activate_action_hidden_for_active_members(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionHidden('activate')
            ->assertActionVisible('resign')
            ->assertActionVisible('retire')
            ->assertActionVisible('suspend')
            ->assertActionVisible('terminate');
    }

    #[Test]
    public function move_action_creates_record_and_updates_role(): void
    {
        $region = Region::create(['name' => 'Test Region', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $district = District::create(['name' => 'Test District', 'regionID' => $region->id, 'countryID' => 196, 'created' => now(), 'createdby' => 0]);
        $newGroup = Group::create(['name' => 'New Group', 'groupTypeID' => 1, 'assoc_to_district' => $district->id, 'assoc_to_region' => $region->id, 'active' => 1, 'created' => now(), 'createdby' => 0]);
        $newRole = SystemUserType::factory()->create();

        $roleAttachment = $this->member->roleAttachments()->first();

        Livewire::actingAs($this->superAdmin)
            ->test(ViewUser::class, ['record' => $this->member->id])
            ->assertActionVisible('move')
            ->callAction('move', data: [
                'roleAttachmentId' => $roleAttachment->id,
                'toPosition' => $newRole->id,
                'toGroup' => $newGroup->id,
                'toDistrict' => $district->id,
                'effectiveDate' => '2026-03-16',
            ])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $this->assertDatabaseHas(AmsAdultLeaderMove::class, [
            'userID' => $this->member->id,
            'ToPosition' => $newRole->id,
            'toGroup' => $newGroup->id,
        ]);

        $roleAttachment->refresh();
        $this->assertEquals($newRole->id, $roleAttachment->roleID);
        $this->assertEquals($newGroup->id, $roleAttachment->groupID);
    }
}
