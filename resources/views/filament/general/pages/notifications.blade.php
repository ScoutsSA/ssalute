<x-filament-panels::page>
    <div class="space-y-4">
        {{-- Tabs --}}
        <div class="flex gap-2">
            <x-filament::button
                :color="$tab === 'active' ? 'primary' : 'gray'"
                wire:click="switchTab('active')"
                size="sm"
            >
                Active
            </x-filament::button>
            <x-filament::button
                :color="$tab === 'dismissed' ? 'primary' : 'gray'"
                wire:click="switchTab('dismissed')"
                size="sm"
            >
                Dismissed
            </x-filament::button>
        </div>

        {{-- Notifications List --}}
        @php
            $notifications = $this->getNotifications();
        @endphp

        @forelse($notifications as $notification)
            <div
                class="flex items-start justify-between gap-4 rounded-lg border bg-white p-4 dark:bg-gray-900"
                style="border-left: 4px solid {{ $notification->colour ?: '#6B7280' }};"
            >
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-950 dark:text-white">
                        {{ $notification->title }}
                    </p>
                    @if($notification->description)
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ $notification->description }}
                        </p>
                    @endif
                    @if($notification->extended)
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ $notification->extended }}
                        </p>
                    @endif
                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">
                        {{ $notification->created?->diffForHumans() }}
                    </p>
                </div>
                @if($tab === 'active' && $notification->userID === auth()->id())
                    <button
                        wire:click="dismiss({{ $notification->id }})"
                        class="shrink-0 rounded-lg border border-gray-200 px-3 py-1.5 text-xs text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
                    >
                        Dismiss
                    </button>
                @endif
            </div>
        @empty
            <div class="rounded-lg border bg-white p-8 text-center dark:bg-gray-900">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $tab === 'active' ? 'No active notifications.' : 'No dismissed notifications.' }}
                </p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-filament-panels::page>
