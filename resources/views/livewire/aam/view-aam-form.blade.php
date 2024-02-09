<div>
    <p class="mb-4">Hi {{auth()->user()->name}}.</p>

    {{$this->aamInfolist}}

    <x-filament-actions::modals />
</div>
