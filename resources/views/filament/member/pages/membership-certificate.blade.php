<x-filament-panels::page>

    {{-- Intro banner --}}
    <div class="overflow-hidden rounded-xl bg-gradient-to-br from-[#622599] to-[#3d1a66] p-6 text-white shadow-lg sm:p-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:gap-6">
            <div class="flex size-14 shrink-0 items-center justify-center rounded-xl bg-white/15 ring-1 ring-white/20 sm:size-16">
                <x-heroicon-o-document-check class="size-7 text-white sm:size-8" />
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold tracking-tight sm:text-xl">Membership Certificate</h2>
                <p class="mt-1 text-sm leading-relaxed text-purple-200/90">
                    Generate a verified, shareable certificate that confirms your active membership with Scouts South Africa. Select the personal information you'd like to display, then share the link with anyone.
                </p>
            </div>
        </div>
    </div>

    {{ $this->form }}
</x-filament-panels::page>
