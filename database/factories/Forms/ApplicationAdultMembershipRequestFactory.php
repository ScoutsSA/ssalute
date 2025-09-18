<?php

namespace Database\Factories\Forms;

use App\Enums\Forms\Aam\AamStatuses;
use App\Enums\UserSex;
use App\Enums\UserTitle;
use App\Models\District;
use App\Models\Group;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationAdultMembershipRequest>
 */
class ApplicationAdultMembershipRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'other_names' => $this->faker->optional()->firstName(),
            'surname' => $this->faker->lastName(),
            'nickname' => $this->faker->optional()->firstName(),
            'title' => $this->faker->randomElement(array_keys(UserTitle::options())),
            'sex' => $this->faker->randomElement(array_keys(UserSex::options())),
            'has_south_african_id' => $this->faker->boolean(),
            'id_number' => $this->faker->unique()->numerify('###########'),
            'id_document' => fn () => UploadedFile::fake()->image('test.jpg')->store('', ['disk' => 'forms_aam_id_document']),
            'criminal_record' => fn () => UploadedFile::fake()->image('test.jpg')->store('', ['disk' => 'forms_aam_criminal_record']),
            'date_of_birth' => $this->faker->date(),
            'passport_country' => $this->faker->optional()->countryCode(),
            'passport_date_of_issue' => fn (array $attributes) => blank($attributes['passport_country'] ?? null) ? null :
                $this->faker->dateTimeBetween(startDate: now()->subYears(80), endDate: now()->subYears(5)),
            'phone_number' => $this->faker->unique()->numerify('27#########'),
            'residential_address' => $this->faker->address(),
            'medical_conditions' => $this->faker->optional()->sentence(),
            'medical_aid_scheme_name' => $this->faker->optional()->company(),
            'medical_aid_number' => $this->faker->optional()->bothify('??######'),
            'medical_aid_principal_member' => $this->faker->optional()->name(),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone_number' => $this->faker->numerify('27#########'),
            'has_given_public_media_consent' => $this->faker->boolean(),
            'group_id' => fn () => Lottery::odds(4, 5)
                ->winner(fn () => Group::inRandomOrder()->first())
                ->loser(fn () => null)
                ->choose(),
            'district_id' => fn (array $attributes) => blank($attributes['group_id'] ?? null) ? null : Group::find($attributes['group_id'])->district->id,
            'region_id' => fn (array $attributes) => blank($attributes['district_id'] ?? null) ? null : District::find($attributes['district_id'])->region->id,
            'created_at' => $this->faker->dateTimeBetween(startDate: now()->subYears(20), endDate: now()),
        ];
    }

    public function approved(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AamStatuses::APPROVED,
                'actioned_at' => $this->faker->dateTimeBetween(startDate: $attributes['created_at'] ?? now(), endDate: now()),
                'actioned_by' => SystemUser::inRandomOrder()->first()->id,
                'actioned_notes_internal' => $this->faker->sentence(),
                'actioned_reason_external' => $this->faker->sentence(),
            ];
        });
    }

    public function declined(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => AamStatuses::DECLINED,
                'actioned_at' => $this->faker->dateTimeBetween(startDate: $attributes['created_at'], endDate: now()),
                'actioned_by' => SystemUser::inRandomOrder()->first()->id,
                'actioned_notes_internal' => $this->faker->sentence(),
                'actioned_reason_external' => $this->faker->sentence(),
            ];
        });
    }
}
