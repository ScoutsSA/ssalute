<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\EventResource;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\ProgramResource;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class GroupOperationsClusterTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string}> */
    public static function resourceProvider(): array
    {
        return [
            'programs' => [ProgramResource::class],
            'events' => [EventResource::class],
        ];
    }

    #[Test]
    #[DataProvider('resourceProvider')]
    public function super_admin_can_access_group_operations_resource_list(string $resourceClass): void
    {
        $url = $resourceClass::getUrl('index');

        $this->actingAs($this->superAdmin)
            ->get($url)
            ->assertOk();
    }

    #[Test]
    #[DataProvider('resourceProvider')]
    public function regular_user_is_forbidden_from_group_operations_resource(string $resourceClass): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $url = $resourceClass::getUrl('index');

        $this->actingAs($user)
            ->get($url)
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_group_operations_cluster(): void
    {
        $url = ProgramResource::getUrl('index');

        $this->get($url)
            ->assertRedirect();
    }
}
