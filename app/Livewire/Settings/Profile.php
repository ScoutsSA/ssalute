<?php

namespace App\Livewire\Settings;

use App\Models\SystemUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $username = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->username = Auth::user()->username;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'username' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(SystemUser::class)->ignore($user->id),
            ],
        ]);

        $user->username = $validated['username'];

        $user->save();

        if ($user->wasChanged()) {
            Log::info('User Profile Updated', ['user_id' => $user->id, 'new_username' => $user->username, 'previous' => $user->getPrevious()]);
        }

        $this->dispatch('profile-updated', name: $user->name);
    }
}
