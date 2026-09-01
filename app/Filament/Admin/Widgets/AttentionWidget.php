<?php

namespace App\Filament\Admin\Widgets;

use App\Enums\Forms\Aam\AamStatuses;
use App\Filament\Admin\Clusters\DataFixes\DataFixesCluster;
use App\Filament\Admin\Clusters\DataFixes\Pages\FindingsPage;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\ApplicationAdultMembershipRequestResource;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Services\SystemFixes\ReportsFindings;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

/**
 * Everything in the BackOffice waiting for a human: outstanding data-fix
 * findings per worklist and pending AAM requests. Counts are cached for ten
 * minutes because findings() runs live queries; the findings read path itself
 * stays free of writes and logging as the DataFixes convention requires.
 * Future queues (moderation tickets 016, 017, 019) land as extra rows in
 * queues().
 */
class AttentionWidget extends Widget
{
    protected static ?int $sort = 1;

    public const string CACHE_KEY = 'backoffice.dashboard.attention';

    public const int CACHE_SECONDS = 600;

    protected string $view = 'filament.admin.widgets.attention';

    protected int|string|array $columnSpan = 'full';

    /** @return array<int, array{label: string, count: int, url: string}> */
    public function queues(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_SECONDS, function (): array {
            $rows = [];

            foreach ($this->findingsPages() as $pageClass) {
                $fix = app($pageClass::fix());

                if (! $fix instanceof ReportsFindings) {
                    continue;
                }

                $rows[] = [
                    'label' => $pageClass::getNavigationLabel(),
                    'count' => $fix->findings()->count(),
                    'url' => $pageClass::getUrl(),
                ];
            }

            $rows[] = [
                'label' => 'Pending AAM Requests',
                'count' => ApplicationAdultMembershipRequest::query()
                    ->where('status', AamStatuses::PENDING)
                    ->count(),
                'url' => ApplicationAdultMembershipRequestResource::getUrl('index'),
            ];

            return array_values(array_filter($rows, fn (array $row): bool => $row['count'] > 0));
        });
    }

    /**
     * Every data-fix worklist page in the DataFixes cluster. Fixes registered
     * in RunSystemFixes get a page there when they report findings, so new
     * worklists appear here without touching this widget.
     *
     * @return list<class-string<FindingsPage>>
     */
    private function findingsPages(): array
    {
        return array_values(array_filter(
            DataFixesCluster::getClusteredComponents(),
            fn (string $component): bool => is_subclass_of($component, FindingsPage::class),
        ));
    }
}
