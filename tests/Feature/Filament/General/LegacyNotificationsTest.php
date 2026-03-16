<?php

namespace Tests\Feature\Filament\General;

use App\Models\Notification as LegacyNotification;
use App\Models\SystemUser;
use App\Settings\FeatureSettings;
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

        $this->get("/general/{$tenant->id}/notifications")
            ->assertRedirect('/general/login');
    }

    #[Test]
    public function authenticated_user_can_access_notifications_page(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/notifications")
            ->assertOk();
    }

    #[Test]
    public function user_sees_notification_targeted_at_them(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->createNotification([
            'userID' => $user->id,
            'title' => 'Personal notification for test',
        ]);

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/notifications")
            ->assertOk()
            ->assertSee('Personal notification for test');
    }

    #[Test]
    public function user_does_not_see_dismissed_notifications(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->createNotification([
            'userID' => $user->id,
            'title' => 'Dismissed notification',
            'dismissDate' => now(),
            'shown' => 1,
        ]);

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/notifications")
            ->assertOk()
            ->assertDontSee('Dismissed notification');
    }

    #[Test]
    public function user_does_not_see_inactive_notifications(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->createNotification([
            'userID' => $user->id,
            'title' => 'Inactive notification',
            'active' => 0,
        ]);

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/notifications")
            ->assertOk()
            ->assertDontSee('Inactive notification');
    }

    #[Test]
    public function user_does_not_see_notifications_outside_date_window(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->createNotification([
            'userID' => $user->id,
            'title' => 'Future notification',
            'doNotShowBefore' => now()->addDays(10),
        ]);

        $this->createNotification([
            'userID' => $user->id,
            'title' => 'Expired notification',
            'doNotShowAfter' => now()->subDays(10),
        ]);

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/notifications")
            ->assertOk()
            ->assertDontSee('Future notification')
            ->assertDontSee('Expired notification');
    }

    #[Test]
    public function user_does_not_see_other_users_notifications(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $otherUser = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->createNotification([
            'userID' => $otherUser->id,
            'title' => 'Other user notification',
        ]);

        $this->actingAs($user)
            ->get("/general/{$tenant->id}/notifications")
            ->assertOk()
            ->assertDontSee('Other user notification');
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
