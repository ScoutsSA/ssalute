<x-filament-widgets::widget>
    <x-filament::section heading="What's New" icon="heroicon-o-megaphone" collapsible>
        <div class="space-y-4">
            @php
                $features = [
                     [
                        'date' => '2026-03-19',
                        'title' => 'Membership Certificate',
                        'description' => 'Members can now view, share and print a membership certificate, verifying their information publicly. View this in My Profile -> Actions -> Membership Certificate',
                        'icon' => 'heroicon-m-document-check',
                    ],
                    [
                        'date' => '2026-03-16',
                        'title' => 'Audit Logging',
                        'description' => 'All changes made in Ssalute have full audit log tracking & tracing',
                        'icon' => 'heroicon-m-clipboard-document-list',
                    ],
                    [
                        'date' => '2026-03-16',
                        'title' => 'Report System Issues',
                        'description' => 'You can now report system issues directly from the user menu. These are sent to the Ssalute development team.',
                        'icon' => 'heroicon-m-exclamation-triangle',
                    ],
                    [
                        'date' => '2026-03-16',
                        'title' => 'Request Missing Warrants',
                        'description' => 'A new button on the Warrants tab lets you report a missing warrant. It sends a prefilled issue report to your next-in-line scouter.',
                        'icon' => 'heroicon-m-document-check',
                    ],
                    [
                        'date' => '2026-03-16',
                        'title' => 'Improved Notifications',
                        'description' => 'Legacy SD Notifications are now displayed in a proper table with search, filters, and bulk dismiss. Expired notifications show in the Dismissed filter.',
                        'icon' => 'heroicon-m-bell-alert',
                    ],
                    [
                        'date' => '2026-03-16',
                        'title' => 'Area Browsing Improvements',
                        'description' => 'Improved the filters, click through and search for the Area Browsing',
                        'icon' => 'heroicon-m-map',
                    ],
                    [
                        'date' => '2026-03-16',
                        'title' => 'Enhanced Profile View',
                        'description' => 'All profile tabs now show more fields including geographic context, validation details, cancellation info, and certificate links.',
                        'icon' => 'heroicon-m-user-circle',
                    ],
                    [
                        'date' => '2026-03-14',
                        'title' => 'Profile Self-Service',
                        'description' => 'View and edit your profile, file upload is still pending',
                        'icon' => 'heroicon-m-pencil-square',
                    ],
                    [
                        'date' => '2026-03-14',
                        'title' => 'Browse Areas',
                        'description' => 'Explore regions, districts and groups with detailed information including contact details, social links, and Google Maps.',
                        'icon' => 'heroicon-m-globe-europe-africa',
                    ],
                ];
            @endphp

            @foreach ($features as $feature)
                <div class="flex items-start gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-primary-50 dark:bg-primary-950">
                        <x-filament::icon :icon="$feature['icon']" class="h-4 w-4 text-primary-500" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold text-gray-950 dark:text-white">
                                {{ $feature['title'] }}
                            </p>
                            <span class="shrink-0 rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($feature['date'])->format('j M Y') }}
                            </span>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                            {{ $feature['description'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
