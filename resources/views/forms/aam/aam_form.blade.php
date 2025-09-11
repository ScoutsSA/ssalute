<div class="mt-6">
    @if($this->successfullyCompletedForm === false)
        <form wire:submit="create">
            {{ $this->form }}

        </form>
    @else
    <div class="text-info-500 text-center">
        <p>
            You have successfully applied as an Adult Member!
        </p>
        <p>
            You will receive an email shortly confirming the information you filled in, but you don't need to take any action from it at all.
        </p>
    </div>
    @endif
    <x-filament-actions::modals />
</div>
