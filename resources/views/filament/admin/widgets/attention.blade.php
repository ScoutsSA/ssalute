<x-filament-widgets::widget>
    <x-filament::section heading="Needs Attention" icon="heroicon-o-bell-alert">
        @php($queues = $this->queues())

        @if (empty($queues))
            <div class="flex items-center gap-3 rounded-lg bg-success-50 p-4 dark:bg-success-400/10">
                <x-filament::icon icon="heroicon-o-check-circle" class="h-6 w-6 shrink-0 text-success-600 dark:text-success-400" />
                <p class="text-sm text-success-700 dark:text-success-300">
                    Nothing is waiting for attention. Every data-fix worklist is clear.
                </p>
            </div>
        @else
            <ul class="-mx-2 flex flex-col gap-1">
                @foreach ($queues as $queue)
                    <li>
                        <a
                            href="{{ $queue['url'] }}"
                            x-data="{}"
                            x-tooltip="{ content: @js($queue['description']), theme: $store.theme }"
                            class="group flex items-center gap-3 rounded-lg px-3 py-2.5 transition duration-75 hover:bg-gray-100 focus-visible:bg-gray-100 dark:hover:bg-white/5 dark:focus-visible:bg-white/5"
                        >
                            <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-warning-100 dark:bg-warning-400/10">
                                <x-filament::icon :icon="$queue['icon']" class="size-5 text-warning-600 dark:text-warning-400" />
                            </span>
                            <span class="flex-1 truncate text-sm font-medium text-gray-700 group-hover:text-gray-950 dark:text-gray-200 dark:group-hover:text-white">
                                {{ $queue['label'] }}
                            </span>
                            <x-filament::badge color="warning" size="lg">
                                {{ number_format($queue['count']) }}
                            </x-filament::badge>
                            <x-filament::icon icon="heroicon-m-chevron-right" class="size-4 shrink-0 text-gray-400 transition duration-75 group-hover:translate-x-0.5 group-hover:text-gray-600 dark:group-hover:text-gray-300" />
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-3 border-t border-gray-200 pt-3 dark:border-white/10">
                <x-filament::link :href="\App\Filament\Admin\Clusters\DataFixes\DataFixesCluster::getUrl()" icon="heroicon-m-wrench-screwdriver" size="sm" color="gray">
                    Open Data Fixes
                </x-filament::link>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
