@php
    $user = auth()->user();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <div class="flex size-14 items-center justify-center rounded-full bg-primary-100 text-xl font-bold text-primary-600 dark:bg-primary-500/20 dark:text-primary-400">
                    {{ $user->initials() }}
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-950 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->username }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->ssa_id }}</p>
                </div>
            </div>

            @unless ($user->hasAnyActiveRole())
                <div class="rounded-lg border border-warning-300 bg-warning-50 p-4 dark:border-warning-600 dark:bg-warning-950/50">
                    <div class="flex gap-3">
                        <x-heroicon-o-exclamation-triangle class="mt-0.5 size-5 shrink-0 text-warning-500" />
                        <div>
                            <h3 class="font-medium text-warning-800 dark:text-warning-200">No Active Role</h3>
                            <p class="mt-1 text-sm text-warning-700 dark:text-warning-300">
                                Your account does not have an active role assigned. To access the full system, please contact your Group Scouter or District Commissioner to have a role assigned to you.
                            </p>
                        </div>
                    </div>
                </div>
            @endunless

            <div class="grid gap-4 sm:grid-cols-2">
                @if ($user->cellNr)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cell Number</dt>
                        <dd class="mt-1 text-sm text-gray-950 dark:text-white">{{ $user->cellNr }}</dd>
                    </div>
                @endif
                @if ($user->dob)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</dt>
                        <dd class="mt-1 text-sm text-gray-950 dark:text-white">{{ $user->dob->format('d M Y') }}</dd>
                    </div>
                @endif
                @if ($user->idNumber)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Number</dt>
                        <dd class="mt-1 text-sm text-gray-950 dark:text-white">{{ $user->idNumber }}</dd>
                    </div>
                @endif
                @if ($user->sex)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-950 dark:text-white">{{ $user->sex->getLabel() }}</dd>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
