<?php

namespace App\Livewire\Settings;

use App\Models\SystemUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->email = Auth::user()->username;
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

        $user->fill($validated);

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }
}
