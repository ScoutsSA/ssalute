<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Clusters\AMS\Resources\Awards\AwardResource;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\ChargeResource;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\DisciplinaryResource;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\PastServiceResource;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\PoliceClearanceResource;
use App\Filament\Admin\Clusters\AMS\Resources\Training\TrainingResource;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\WarrantResource;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AmsClusterTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();
    }

    /** @return array<string, array{class-string}> */
    public static function mainResourceProvider(): array
    {
        return [
            'warrants' => [WarrantResource::class],
            'awards' => [AwardResource::class],
            'disciplinary' => [DisciplinaryResource::class],
            'charges' => [ChargeResource::class],
            'police clearances' => [PoliceClearanceResource::class],
            'past service' => [PastServiceResource::class],
            'training' => [TrainingResource::class],
        ];
    }

    #[Test]
    #[DataProvider('mainResourceProvider')]
    public function super_admin_can_access_ams_main_resource_list(string $resourceClass): void
    {
        $url = $resourceClass::getUrl('index');

        $this->actingAs($this->superAdmin)
            ->get($url)
            ->assertOk();
    }

    #[Test]
    #[DataProvider('mainResourceProvider')]
    public function regular_user_is_forbidden_from_ams_main_resource(string $resourceClass): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $url = $resourceClass::getUrl('index');

        $this->actingAs($user)
            ->get($url)
            ->assertForbidden();
    }

    #[Test]
    public function guest_is_redirected_when_accessing_ams_warrants(): void
    {
        $url = WarrantResource::getUrl('index');

        $this->get($url)
            ->assertRedirect();
    }
}
