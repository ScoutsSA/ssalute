<?php

namespace Tests\Feature\Filament\Member;

use App\Filament\Member\Widgets\LegacyNotificationsWidget;
use App\Models\Notification as LegacyNotification;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
use Filament\Facades\Filament;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class LegacyNotificationsWidgetTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $features = resolve(FeatureSettings::class);
        $features->users_can_view_notifications = true;
        $features->save();
    }

    #[Test]
    public function widget_renders_when_user_has_no_notifications(): void
    {
        [$user] = $this->setupUserAndPanel();

        Livewire::actingAs($user)
            ->test(LegacyNotificationsWidget::class)
            ->assertSuccessful();
    }

    #[Test]
    public function widget_renders_when_user_has_notifications(): void
    {
        [$user] = $this->setupUserAndPanel();

        $notification = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Visible widget notification',
        ]);

        Livewire::actingAs($user)
            ->test(LegacyNotificationsWidget::class)
            ->assertSuccessful()
            ->assertSee('Visible widget notification');
    }

    #[Test]
    public function widget_can_view_respects_feature_flag(): void
    {
        $features = resolve(FeatureSettings::class);

        $features->users_can_view_notifications = true;
        $features->save();
        $this->assertTrue(LegacyNotificationsWidget::canView());

        $features->users_can_view_notifications = false;
        $features->save();
        $this->assertFalse(LegacyNotificationsWidget::canView());
    }

    #[Test]
    public function widget_dismiss_marks_notification_as_dismissed(): void
    {
        [$user] = $this->setupUserAndPanel();

        $notification = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Dismissable widget notification',
        ]);

        Livewire::actingAs($user)
            ->test(LegacyNotificationsWidget::class)
            ->call('dismiss', $notification->id);

        $fresh = $notification->fresh();
        $this->assertNotNull($fresh->dismissDate);
        $this->assertSame(1, (int) $fresh->shown);
    }

    #[Test]
    public function widget_dismiss_does_not_affect_other_users_notifications(): void
    {
        [$user] = $this->setupUserAndPanel();
        $otherUser = SystemUser::factory()->create();

        $other = $this->createNotification([
            'userID' => $otherUser->id,
            'title' => 'Other user widget notification',
        ]);

        Livewire::actingAs($user)
            ->test(LegacyNotificationsWidget::class)
            ->call('dismiss', $other->id);

        $this->assertNull($other->fresh()->dismissDate);
    }

    #[Test]
    public function widget_excludes_notifications_outside_visibility_window(): void
    {
        [$user] = $this->setupUserAndPanel();

        $expired = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Expired widget notification',
            'doNotShowAfter' => now()->subDay(),
        ]);

        $future = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Future widget notification',
            'doNotShowBefore' => now()->addDay(),
        ]);

        $dismissed = $this->createNotification([
            'userID' => $user->id,
            'title' => 'Already dismissed widget notification',
            'dismissDate' => now(),
            'shown' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(LegacyNotificationsWidget::class)
            ->assertSuccessful()
            ->assertDontSee('Expired widget notification')
            ->assertDontSee('Future widget notification')
            ->assertDontSee('Already dismissed widget notification');
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
