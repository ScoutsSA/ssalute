<x-layouts.auth.simple>
    <div class="flex flex-col gap-4 rounded-xl border border-neutral-200 bg-white p-6 text-center shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
        <h1 class="text-lg font-semibold text-neutral-900 dark:text-white">That link has expired</h1>
        <p class="text-sm text-neutral-600 dark:text-neutral-300">The link from Scouts Digital only works for a minute and only once. Go back and try again, or log in here with your Scouts Digital details.</p>
        <a href="{{ $loginUrl }}" class="rounded-lg bg-[#5C2D91] px-4 py-2 text-sm font-semibold text-white hover:bg-[#4a2475]">Log in</a>
    </div>
</x-layouts.auth.simple>
