<x-filament-widgets::widget>
    @php
        $notifications = $this->getNotifications();
    @endphp

    @if ($notifications->isNotEmpty())
        <x-filament::section heading="Notifications" icon="heroicon-o-bell-alert">
            <div class="space-y-3">
                @foreach ($notifications as $notification)
                    <div
                        class="flex items-start justify-between gap-4 rounded-lg border p-3"
                        style="border-left: 4px solid {{ $notification->colour ?: '#6B7280' }};"
                    >
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-950 dark:text-white">
                                {{ $notification->title }}
                            </p>
                            @if ($notification->description)
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $notification->description }}
                                </p>
                            @endif
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                {{ $notification->created?->diffForHumans() }}
                            </p>
                        </div>
                        @if ($notification->userID === auth()->id())
                            <button
                                wire:click="dismiss({{ $notification->id }})"
                                class="shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                title="Dismiss"
                            >
                                <x-heroicon-m-x-mark class="h-4 w-4" />
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            <x-slot name="footerActions">
                <x-filament::link
                    :href="\App\Filament\General\Pages\Notifications::getUrl()"
                    icon="heroicon-m-arrow-right"
                    icon-position="after"
                >
                    View All Notifications
                </x-filament::link>
            </x-slot>
        </x-filament::section>
    @endif
</x-filament-widgets::widget>
