<?php

namespace Tests\Feature\Models;

use App\Models\District;
use App\Models\Region;
use App\Models\SystemUser;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * MightHaveCreatedBy and MightHaveModifiedBy stamp the legacy audit columns on any model that casts them.
 */
class AuditColumnStampingTest extends SdCoreTestCase
{
    #[Test]
    public function an_authenticated_create_stamps_createdby_and_modifiedby(): void
    {
        $user = SystemUser::factory()->create();
        $this->actingAs($user);

        $attributes = District::factory()->raw();
        unset($attributes['createdby'], $attributes['modifiedby']);

        $district = District::query()->create($attributes);

        $this->assertSame($user->id, $district->fresh()->createdby);
        $this->assertSame($user->id, $district->fresh()->modifiedby);
        $this->assertNotNull($district->fresh()->created);
    }

    #[Test]
    public function an_authenticated_update_changes_modifiedby_only(): void
    {
        $district = District::factory()->create(['createdby' => 7, 'modifiedby' => 7]);

        $user = SystemUser::factory()->create();
        $this->actingAs($user);

        $district->update(['name' => 'Renamed']);

        $this->assertSame(7, $district->fresh()->createdby);
        $this->assertSame($user->id, $district->fresh()->modifiedby);
    }

    #[Test]
    public function an_explicit_value_is_honoured(): void
    {
        $this->actingAs(SystemUser::factory()->create());

        $district = District::factory()->create(['createdby' => 42, 'modifiedby' => 43]);

        $this->assertSame(42, $district->fresh()->createdby);
        $this->assertSame(43, $district->fresh()->modifiedby);
    }

    #[Test]
    public function a_model_without_the_columns_is_left_alone(): void
    {
        $this->actingAs(SystemUser::factory()->create());

        $region = Region::factory()->create();

        $this->assertArrayNotHasKey('createdby', $region->getAttributes());
        $this->assertArrayNotHasKey('modifiedby', $region->getAttributes());
    }

    #[Test]
    public function nothing_is_stamped_without_an_authenticated_user(): void
    {
        $district = District::factory()->create(['createdby' => 5, 'modifiedby' => null]);

        $this->assertSame(5, $district->fresh()->createdby);
        $this->assertNull($district->fresh()->modifiedby);
    }
}
