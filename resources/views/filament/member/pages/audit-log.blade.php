<x-filament-panels::page>
    <x-filament::section compact>
        <div class="flex items-start gap-3">
            <x-filament::icon icon="heroicon-o-information-circle" class="h-5 w-5 shrink-0 text-primary-500 mt-0.5" />
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <p>
                    This log shows all changes which you have made through Ssalute. Field names and values shown here are the <strong>system-level model and database names</strong>, which may differ from the labels you see in the interface.
                    For example, <code>SystemUser</code> refers to your User, and <code>SystemUserOtherRole</code> is your role attachment.
                </p>
            </div>
        </div>
    </x-filament::section>

    {{ $this->table }}
</x-filament-panels::page>
