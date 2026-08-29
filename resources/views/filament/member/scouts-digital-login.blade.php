@if($enabled)
    <div class="flex items-center gap-3 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
        <span class="h-px flex-1 bg-gray-200 dark:bg-white/10"></span>
        <span>or</span>
        <span class="h-px flex-1 bg-gray-200 dark:bg-white/10"></span>
    </div>

    <x-filament::button tag="a" color="gray" outlined class="w-full" :href="$url">
        Log in via Scouts.Digital
    </x-filament::button>
@endif
