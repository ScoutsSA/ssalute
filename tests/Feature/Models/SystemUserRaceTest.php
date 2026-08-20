<?php

namespace Tests\Feature\Models;

use App\Enums\UserRace;
use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

/**
 * Race is read leniently and written strictly.
 *
 * Legacy sd-core rows carry surrounding whitespace on this column, which a plain backed-enum
 * cast turns into a ValueError on read, taking down every screen that shows the member.
 */
class SystemUserRaceTest extends SdCoreTestCase
{
    #[Test]
    public function a_user_whose_stored_race_carries_trailing_whitespace_resolves_to_the_enum_case(): void
    {
        $user = $this->userWithStoredRace('African ');

        $this->assertSame(UserRace::African, $user->race);
    }

    #[Test]
    public function a_user_whose_stored_race_carries_leading_whitespace_resolves_to_the_enum_case(): void
    {
        $user = $this->userWithStoredRace('  Coloured');

        $this->assertSame(UserRace::Coloured, $user->race);
    }

    #[Test]
    public function an_unrecognised_stored_race_reads_as_null_instead_of_throwing(): void
    {
        $user = $this->userWithStoredRace('Martian');

        $this->assertNull($user->race);
    }

    #[Test]
    public function a_stored_race_that_is_only_whitespace_reads_as_null(): void
    {
        $user = $this->userWithStoredRace('   ');

        $this->assertNull($user->race);
    }

    #[Test]
    public function a_clean_stored_race_still_resolves(): void
    {
        $user = $this->userWithStoredRace('Caucasian');

        $this->assertSame(UserRace::Caucasian, $user->race);
    }

    #[Test]
    public function saving_an_enum_race_persists_the_canonical_backing_value(): void
    {
        $user = SystemUser::factory()->create();

        $user->update(['race' => UserRace::African]);

        $this->assertSame('African', $this->storedRace($user));
        $this->assertSame(UserRace::African, $user->fresh()->race);
    }

    #[Test]
    public function saving_a_race_string_that_carries_whitespace_persists_the_canonical_backing_value(): void
    {
        $user = SystemUser::factory()->create();

        $user->update(['race' => 'African ']);

        $this->assertSame('African', $this->storedRace($user));
    }

    #[Test]
    public function saving_a_null_race_persists_null(): void
    {
        $user = SystemUser::factory()->create(['race' => UserRace::Indian]);

        $user->update(['race' => null]);

        $this->assertNull($this->storedRace($user));
    }

    #[Test]
    public function saving_an_unrecognised_race_is_rejected_and_writes_nothing(): void
    {
        $user = SystemUser::factory()->create(['race' => UserRace::Indian]);

        try {
            $user->update(['race' => 'Martian']);
            $this->fail('Expected an unrecognised race to be rejected.');
        } catch (InvalidArgumentException $exception) {
            $this->assertStringContainsString('Martian', $exception->getMessage());
        }

        $this->assertSame('Indian', $this->storedRace($user));
    }

    /**
     * Seed a raw column value the enum would refuse, bypassing the model's own mutator.
     */
    private function userWithStoredRace(string $race): SystemUser
    {
        $user = SystemUser::factory()->create();

        DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('system_users')
            ->where('id', $user->id)
            ->update(['race' => $race]);

        return $user->fresh();
    }

    private function storedRace(SystemUser $user): ?string
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE)
            ->table('system_users')
            ->where('id', $user->id)
            ->value('race');
    }
}
