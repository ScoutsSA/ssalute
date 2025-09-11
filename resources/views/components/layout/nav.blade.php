<nav class="max-w-6xl mx-auto px-4 lg:px-6 h-14 flex items-center justify-between">
    <a href="/" class="font-semibold tracking-tight text-[15px]">Ssalute</a>

    <div class="flex items-center gap-6 text-[14px]">
        <!-- Forms group -->
        <div class="relative group/nav">
            <button type="button" aria-haspopup="menu" aria-expanded="false"
                    class="cursor-default select-none text-[#3a3a36] dark:text-[#EDEDEC] hover:text-black dark:hover:text-white flex items-center gap-1">
                <span>Forms</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                     class="size-4 opacity-70 transition-transform group-hover/nav:rotate-180">
                    <path fill-rule="evenodd"
                          d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
            <div
                class="pointer-events-none absolute right-0 top-full w-56 rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-lg p-1 opacity-0 translate-y-1 transition ease-out duration-150 group-hover/nav:pointer-events-auto group-hover/nav:opacity-100 group-hover/nav:translate-y-0 group-focus-within/nav:pointer-events-auto group-focus-within/nav:opacity-100 group-focus-within/nav:translate-y-0">

                @if(resolve(\App\Settings\FormSettings::class)->aam_enabled)
                    <a href="{{route('forms.register.adult.aam')}}" class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">AAM</a>
                @else
                    <a href="#" disabled class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">AAM - Coming Soon!</a>
                @endif
                <a href="#" class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">RALA - Coming
                    Soon!</a>
                <a href="#" class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Youth Application
                    Form - Coming Soon!</a>
            </div>
        </div>

        <!-- Tools group -->
        <div class="relative group/nav">
            <button type="button" aria-haspopup="menu" aria-expanded="false"
                    class="cursor-default select-none text-[#3a3a36] dark:text-[#EDEDEC] hover:text-black dark:hover:text-white flex items-center gap-1">
                <span>Tools</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                     class="size-4 opacity-70 transition-transform group-hover/nav:rotate-180">
                    <path fill-rule="evenodd"
                          d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
            <div
                class="pointer-events-none absolute right-0 top-full w-56 rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-lg p-1 opacity-0 translate-y-1 transition ease-out duration-150 group-hover/nav:pointer-events-auto group-hover/nav:opacity-100 group-hover/nav:translate-y-0 group-focus-within/nav:pointer-events-auto group-focus-within/nav:opacity-100 group-focus-within/nav:translate-y-0">
                <a href="{{ route('tools.sd.check-account') }}"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Check User
                    Existence</a>
            </div>
        </div>

        <!-- Other Applications group -->
        <div class="relative group/nav">
            <button type="button" aria-haspopup="menu" aria-expanded="false"
                    class="cursor-default select-none text-[#3a3a36] dark:text-[#EDEDEC] hover:text-black dark:hover:text-white flex items-center gap-1">
                <span>Other Applications</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                     class="size-4 opacity-70 transition-transform group-hover/nav:rotate-180">
                    <path fill-rule="evenodd"
                          d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08Z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
            <div
                class="pointer-events-none absolute right-0 top-full w-56 rounded-md border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-lg p-1 opacity-0 translate-y-1 transition ease-out duration-150 group-hover/nav:pointer-events-auto group-hover/nav:opacity-100 group-hover/nav:translate-y-0 group-focus-within/nav:pointer-events-auto group-focus-within/nav:opacity-100 group-focus-within/nav:translate-y-0">
                <a href="https://ssa.scouts.digital/"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Scouts Digital</a>
                <a href="https://permits.scouts.org.za"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Permit System</a>
                <a href="https://lists.scouts.org.za"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Email Lists</a>
                <a href="https://scoutwiki.scouts.org.za/"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Wiki</a>
                <a href="https://www.scouts.org.za/get-involved/scouts-sa-alumni/"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Alumni</a>
                <a href="https://support.scouts.org.za/"
                   class="block rounded px-3 py-2 hover:bg-[#f5f5f4] dark:hover:bg-[#232322]">Support</a>
            </div>
        </div>
    </div>
</nav>
