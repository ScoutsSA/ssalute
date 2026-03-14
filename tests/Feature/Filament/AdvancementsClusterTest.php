<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\CubAdvancementResource;
use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\MeerkatAdvancementResource;
use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\RoverAdvancementResource;
use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\ScoutAdvancementResource;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AdvancementsClusterTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string}> */
    public static function advancementResourceProvider(): array
    {
        return [
            'meerkat advancements' => [MeerkatAdvancementResource::class],
            'cub advancements' => [CubAdvancementResource::class],
            'scout advancements' => [ScoutAdvancementResource::class],
            'rover advancements' => [RoverAdvancementResource::class],
        ];
    }

    #[Test]
    #[DataProvider('advancementResourceProvider')]
    public function super_admin_can_access_advancement_resource_list(string $resourceClass): void
    {
        $url = $resourceClass::getUrl('index');

        $this->actingAs($this->superAdmin)
            ->get($url)
            ->assertOk();
    }

    #[Test]
    #[DataProvider('advancementResourceProvider')]
    public function regular_user_is_forbidden_from_advancement_resource(string $resourceClass): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $url = $resourceClass::getUrl('index');

        $this->actingAs($user)
            ->get($url)
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_advancements_cluster(): void
    {
        $url = MeerkatAdvancementResource::getUrl('index');

        $this->get($url)
            ->assertRedirect();
    }
}
