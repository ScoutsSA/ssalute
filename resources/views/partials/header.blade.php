<div class="contents">
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                {{ __('Home') }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />


        <flux:dropdown position="top" align="end" class="hidden lg:block">
            <button type="button" class="group flex items-center rounded-lg has-data-[circle=true]:rounded-full [ui-dropdown>&]:w-full p-1 hover:bg-zinc-800/5 dark:hover:bg-white/10 cursor-pointer" >
                <div class="shrink-0">
                    Forms
                </div>
                <div class="shrink-0 ms-auto size-8 flex justify-center items-center">
                    <flux:icon icon="chevron-down" variant="micro" class="text-zinc-400 dark:text-white/80 group-hover:text-zinc-800 dark:group-hover:text-white" />
                </div>
            </button>
            <flux:menu>
                <flux:menu.radio.group>
                    @if (resolve(\App\Settings\FormSettings::class)->aam_enabled)
                        <flux:menu.item href="{{ route('forms.aam.form') }}" wire:navigate>Adult Applications</flux:menu.item>
                    @else
                        <flux:menu.item :disabled="true">Adult Applications</flux:menu.item>
                    @endif
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :disabled="true">RALA - Coming Soon</flux:menu.item>
                    <flux:menu.item :disabled="true">Youth Application - Coming Soon!</flux:menu.item>
                </flux:menu.radio.group>


            </flux:menu>
        </flux:dropdown>


        <flux:dropdown position="top" align="end" class="hidden lg:block">
            <button type="button" class="group flex items-center rounded-lg has-data-[circle=true]:rounded-full [ui-dropdown>&]:w-full p-1 hover:bg-zinc-800/5 dark:hover:bg-white/10 cursor-pointer" >
                <div class="shrink-0">
                    Tools
                </div>
                <div class="shrink-0 ms-auto size-8 flex justify-center items-center">
                    <flux:icon icon="chevron-down" variant="micro" class="text-zinc-400 dark:text-white/80 group-hover:text-zinc-800 dark:group-hover:text-white" />
                </div>
            </button>
            <flux:menu>
                <flux:menu.radio.group>
                        <flux:menu.item href="{{ route('tools.sd.check-account') }}" wire:navigate>Check User Existence</flux:menu.item>
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>

        <flux:dropdown position="top" align="end">
            <button type="button" class="group flex items-center rounded-lg has-data-[circle=true]:rounded-full [ui-dropdown>&]:w-full p-1 hover:bg-zinc-800/5 dark:hover:bg-white/10 cursor-pointer" >
                <div class="shrink-0">
                    Links
                </div>
                <div class="shrink-0 ms-auto size-8 flex justify-center items-center">
                    <flux:icon icon="chevron-down" variant="micro" class="text-zinc-400 dark:text-white/80 group-hover:text-zinc-800 dark:group-hover:text-white" />
                </div>
            </button>
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.item href="https://ssa.scouts.digital/">Scouts Digital</flux:menu.item>
                    <flux:menu.item href="https://permits.scouts.org.za">Permit System</flux:menu.item>
                    <flux:menu.item href="https://lists.scouts.org.za">Email Lists</flux:menu.item>
                    <flux:menu.item href="https://scoutwiki.scouts.org.za/">Wiki</flux:menu.item>
                    <flux:menu.item href="https://www.scouts.org.za/get-involved/scouts-sa-alumni/">Alumni</flux:menu.item>
                    <flux:menu.item href="https://support.scouts.org.za/">Support</flux:menu.item>
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>

        @auth
            <!-- Desktop User Menu -->
            <flux:dropdown position="top" align="end">
                <flux:profile
                    class="cursor-pointer"
                    :initials="auth()->user()->initials()"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>


                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        @if (auth()->user()->isSuperAdmin())
                            <flux:menu.item :href="\Filament\Pages\Dashboard::getUrl(panel: 'admin')" icon="cog">{{ __('Backoffice Admin Panel') }}</flux:menu.item>
                        @endif
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        @else
            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
            <flux:menu.item :href="route('login')" wire:navigate>{{ __('Log In') }}</flux:menu.item>
            </flux:navbar>
        @endauth
    </flux:header>
    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Forms')">
                @if (resolve(\App\Settings\FormSettings::class)->aam_enabled)
                    <flux:navlist.item  href="{{ route('forms.aam.form') }}" :current="request()->routeIs('forms.aam.form')" wire:navigate>{{ __('Adult Applications') }}</flux:navlist.item>
                @else
                    <flux:navlist.item disabled="true" :current="request()->routeIs('forms.aam.form')" wire:navigate>{{ __('Adult Applications') }}</flux:navlist.item>
                @endif
            </flux:navlist.group>
        </flux:navlist>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Tools')">
                <flux:navlist.item :current="request()->routeIs('tools.sd.check-account')" wire:navigate href="{{ route('tools.sd.check-account') }}">{{ __('Check User Existence') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>


        <flux:spacer />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/ScoutsSA/ssalute" target="_blank">
                {{ __('GitHub!') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>
</div>
