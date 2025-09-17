<?php

namespace Database\Factories\Forms;

use App\Enums\UserSex;
use App\Enums\UserTitle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

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
            'date_of_birth' => $this->faker->optional()->date(),
            'passport_country' => $this->faker->optional()->countryCode(),
            'passport_date_of_issue' => $this->faker->optional()->date(),
            'phone_number' => $this->faker->unique()->numerify('27#########'),
            'residential_address' => $this->faker->optional()->address(),
            'medical_conditions' => $this->faker->optional()->sentence(),
            'medical_aid_scheme_name' => $this->faker->optional()->company(),
            'medical_aid_number' => $this->faker->optional()->bothify('??######'),
            'medical_aid_principal_member' => $this->faker->optional()->name(),
            'emergency_contact_name' => $this->faker->optional()->name(),
            'emergency_contact_phone_number' => $this->faker->optional()->numerify('27#########'),
            'has_given_public_media_consent' => $this->faker->boolean(),
            'region_id' => null,
            'district_id' => null,
            'group_id' => null,
        ];
    }
}
