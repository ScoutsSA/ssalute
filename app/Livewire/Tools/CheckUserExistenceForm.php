<?php

namespace App\Livewire\Tools;

use App\Models\SystemUser;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CheckUserExistenceForm extends Component
{
    use WithRateLimiting;

    public ?string $email = null;

    public ?bool $exists = null;

    public function render()
    {
        return view('tools.check-existence.check-user-existence-form')
            ->layoutData([
                'title' => 'Check User Existence - Ssalute',
            ]);
    }

    public function checkEmail()
    {
        try {
            $this->rateLimit(10);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'submit' => "Slow down! Please wait another {$exception->secondsUntilAvailable} seconds before you check again.",
            ]);
        }
        $this->exists = null;
        $this->validate(
            ['email' => 'required|email']
        );

        $this->exists = SystemUser::where('username', $this->email)->exists();
    }
}
