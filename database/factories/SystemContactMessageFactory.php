<?php

namespace Database\Factories;

use App\Enums\DirectoryLevel;
use App\Models\SystemContactMessage;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SystemContactMessage>
 */
class SystemContactMessageFactory extends Factory
{
    protected $model = SystemContactMessage::class;

    public function definition(): array
    {
        return [
            'sender_user_id' => SystemUser::factory(),
            'recipient_user_id' => SystemUser::factory(),
            'directory_level' => DirectoryLevel::Group,
            'subject' => $this->faker->sentence(4),
            'message' => $this->faker->paragraph(),
            'sent_at' => now(),
        ];
    }
}
