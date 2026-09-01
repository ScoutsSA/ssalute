<x-filament-widgets::widget>
    <x-filament::section heading="Needs Attention" icon="heroicon-o-bell-alert">
        @php($queues = $this->queues())

        @if (empty($queues))
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Nothing is waiting for attention. Data-fix worklists are clear and there are no pending AAM requests.
            </p>
        @else
            <ul class="divide-y divide-gray-200 dark:divide-white/10">
                @foreach ($queues as $queue)
                    <li>
                        <a href="{{ $queue['url'] }}" class="flex items-center justify-between gap-4 py-2 text-sm hover:underline">
                            <span>{{ $queue['label'] }}</span>
                            <x-filament::badge color="warning">
                                {{ number_format($queue['count']) }}
                            </x-filament::badge>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
