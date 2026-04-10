@php
    $roles = $this->getAffectedRoles();
@endphp

<x-filament-widgets::widget>
    <div class="rounded-xl border border-danger-300 bg-danger-50 p-4 dark:border-danger-600 dark:bg-danger-950/50">
        <div class="flex gap-3">
            <x-heroicon-o-document-check class="mt-0.5 size-5 shrink-0 text-danger-500" />
            <div>
                <h3 class="font-medium text-danger-800 dark:text-danger-200">Missing Appointment</h3>
                <p class="mt-1 text-sm text-danger-700 dark:text-danger-300">
                    The following role(s) require a valid appointment before you can access them. Please contact your next in line Scouter to have your appointment issued.
                </p>
                <ul class="mt-3 space-y-1">
                    @foreach ($roles as $role)
                        <li class="flex items-center gap-2 text-sm text-danger-700 dark:text-danger-300">
                            <x-heroicon-m-x-circle class="size-4 shrink-0" />
                            <span class="font-medium">{{ $role->role->name }}</span>
                            @if ($role->roleScopedLabel)
                                <span class="text-danger-500 dark:text-danger-400">({{ $role->roleScopedLabel }})</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
