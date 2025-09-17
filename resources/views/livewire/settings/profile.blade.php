<div class="max-w-6xl mx-auto">
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Profile')" :subheading="__('Update your email address')">
            <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
                <div>
                    <flux:input wire:model="username" :label="__('Email')" type="email" required autocomplete="email" />
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>

        </x-settings.layout>
    </section>
</div>
