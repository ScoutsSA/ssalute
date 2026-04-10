<?php

namespace Tests\Feature\Filament\Member;

use App\Filament\Member\Pages\Notifications;
use App\Models\Notification as LegacyNotification;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class LegacyNotificationsTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_view_notifications = true;
        $features->save();
    }

    #[Test]
    public function guest_cannot_access_notifications_page(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->get("/member/{$tenant->id}/notifications")
            ->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_access_notifications_page(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertOk();
    }

    #[Test]
    public function user_sees_active_notifications_by_default(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $notification = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Active notification',
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertCanSeeTableRecords([$notification]);
    }

    #[Test]
    public function user_does_not_see_dismissed_notifications_by_default(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $dismissed = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Dismissed notification',
            'dismissDate' => now(),
            'shown' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertCanNotSeeTableRecords([$dismissed]);
    }

    #[Test]
    public function dismissed_filter_shows_dismissed_and_expired_notifications(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $dismissed = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Dismissed notification',
            'dismissDate' => now(),
            'shown' => 1,
        ]);

        $expired = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Expired notification',
            'doNotShowAfter' => now()->subDay(),
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->filterTable('status', 'dismissed')
            ->assertCanSeeTableRecords([$dismissed, $expired]);
    }

    #[Test]
    public function expired_notifications_do_not_appear_in_active_filter(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $expired = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Expired notification',
            'doNotShowAfter' => now()->subDay(),
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertCanNotSeeTableRecords([$expired]);
    }

    #[Test]
    public function user_does_not_see_inactive_notifications(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $inactive = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Inactive notification',
            'active' => 0,
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertCanNotSeeTableRecords([$inactive]);
    }

    #[Test]
    public function user_does_not_see_future_notifications(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $future = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Future notification',
            'doNotShowBefore' => now()->addDays(10),
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertCanNotSeeTableRecords([$future]);
    }

    #[Test]
    public function user_does_not_see_other_users_notifications(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();
        $otherUser = SystemUser::factory()->create();

        $other = $this->createNotification([
            'userID' => $otherUser->id,
            'title' => 'Other user notification',
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->assertCanNotSeeTableRecords([$other]);
    }

    #[Test]
    public function user_can_dismiss_a_notification(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $notification = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Dismissable notification',
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->callAction(TestAction::make('dismiss')->table($notification));

        $this->assertNotNull($notification->fresh()->dismissDate);
    }

    #[Test]
    public function user_can_bulk_dismiss_notifications(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $n1 = $this->createNotification(['userID' => $user->id, 'title' => 'First']);
        $n2 = $this->createNotification(['userID' => $user->id, 'title' => 'Second']);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->selectTableRecords([$n1->id, $n2->id])
            ->callAction(TestAction::make('dismiss')->table()->bulk());

        $this->assertNotNull($n1->fresh()->dismissDate);
        $this->assertNotNull($n2->fresh()->dismissDate);
    }

    #[Test]
    public function dismiss_action_is_hidden_for_already_dismissed_notifications(): void
    {
        [$user, $tenant] = $this->setupUserAndPanel();

        $dismissed = $this->createNotification([
            'userID' => $user->id,
            'dismissDate' => now(),
            'shown' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(Notifications::class)
            ->filterTable('status', 'dismissed')
            ->assertActionHidden(TestAction::make('dismiss')->table($dismissed));
    }

    private function setupUserAndPanel(): array
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user);
        Filament::setCurrentPanel(Filament::getPanel('member'));
        Filament::setTenant($tenant);

        return [$user, $tenant];
    }

    private function createNotification(array $attributes = []): LegacyNotification
    {
        return LegacyNotification::create(array_merge([
            'userID' => 0,
            'groupID' => 0,
            'districtID' => 0,
            'regionID' => 0,
            'countryID' => 196,
            'title' => 'Test Notification',
            'description' => 'Test description',
            'extended' => '',
            'colour' => 'teal',
            'active' => 1,
            'doNotShowBefore' => '2020-01-01',
            'doNotShowAfter' => '2030-01-01',
            'forType' => 0,
            'createdby' => 0,
            'shown' => 0,
        ], $attributes));
    }
}
