<?php

namespace Tests\Feature\Filament;

use App\Filament\Admin\Resources\Users\UserResource;
use App\Models\Region;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use Filament\Facades\Filament;
use Filament\Livewire\GlobalSearch;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * The BackOffice global search used to match members on `username` only, because that is the
 * resource's record title attribute and `name` is an accessor. Ticket 030 asked for a member to be
 * found by typing their name, as in "John Roux".
 */
class UserGlobalSearchTest extends SdCoreTestCase
{
    private SystemUser $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = SystemUser::factory()->create();
        app(GeneralSettings::class)->fill(['super_user_admin_list' => [$this->superAdmin->id]])->save();

        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs($this->superAdmin);
    }

    #[Test]
    public function a_member_is_found_by_first_name_and_surname_together(): void
    {
        $member = SystemUser::factory()->create(['first_name' => 'Johannes', 'surname' => 'Rouxel', 'knownName' => '']);
        SystemUser::factory()->create(['first_name' => 'Johannes', 'surname' => 'Smith', 'knownName' => '']);
        SystemUser::factory()->create(['first_name' => 'Peter', 'surname' => 'Rouxel', 'knownName' => '']);

        $titles = UserResource::getGlobalSearchResults('Johannes Rouxel')->map(fn ($result) => $result->title)->all();

        $this->assertSame(["Johannes Rouxel (#{$member->id})"], $titles);
    }

    #[Test]
    public function a_member_is_found_by_known_name_and_by_username(): void
    {
        $member = SystemUser::factory()->create(['first_name' => 'Johannes', 'surname' => 'Rouxel', 'knownName' => 'Jono', 'username' => 'jono.rouxel@example.test']);

        $byKnownName = UserResource::getGlobalSearchResults('Jono')->map(fn ($result) => $result->title)->all();
        $byUsername = UserResource::getGlobalSearchResults('jono.rouxel@example')->map(fn ($result) => $result->title)->all();

        $this->assertSame(["Jono Rouxel (#{$member->id})"], $byKnownName);
        $this->assertSame(["Jono Rouxel (#{$member->id})"], $byUsername);
    }

    #[Test]
    public function a_member_is_found_by_id_number(): void
    {
        $member = SystemUser::factory()->create(['first_name' => 'Johannes', 'surname' => 'Rouxel', 'knownName' => '', 'idNumber' => '8001015009087']);

        $titles = UserResource::getGlobalSearchResults('8001015009')->map(fn ($result) => $result->title)->all();

        $this->assertSame(["Johannes Rouxel (#{$member->id})"], $titles);
    }

    #[Test]
    public function a_result_links_to_the_member_and_shows_their_home_area(): void
    {
        $region = Region::create(['name' => 'Gauteng', 'description' => '', 'phys_address' => '', 'countryID' => 196]);
        $member = SystemUser::factory()->create(['first_name' => 'Johannes', 'surname' => 'Rouxel', 'knownName' => '', 'assoc_to_region' => $region->id]);

        $result = UserResource::getGlobalSearchResults('Rouxel')->sole();

        $this->assertSame(UserResource::getUrl('view', ['record' => $member]), $result->url);
        $this->assertSame("Gauteng (#{$region->id})", $result->details['Region']);
        $this->assertArrayNotHasKey('Group', $result->details);
    }

    #[Test]
    public function the_global_search_box_lists_the_member(): void
    {
        $member = SystemUser::factory()->create(['first_name' => 'Johannes', 'surname' => 'Rouxel', 'knownName' => '']);

        Livewire::test(GlobalSearch::class)
            ->set('search', 'Johannes Rouxel')
            ->assertSee("Johannes Rouxel (#{$member->id})");
    }
}
