<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Clusters\DataFixes\DataFixesCluster;
use App\Filament\Admin\Clusters\DataFixes\Pages\FindingsPage;
use App\Services\SystemFixes\ReportsFindings;
use BackedEnum;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

/**
 * Everything in the BackOffice waiting for a human, one row per outstanding
 * queue. Data-fix worklists are discovered from the DataFixes cluster, so a
 * new fix page appears here without touching this widget; future queues (the
 * moderation tickets 016, 017 and 019) land as extra rows in queues(). Counts
 * are cached for ten minutes because findings() runs live queries; the
 * findings read path itself stays free of writes and logging as the DataFixes
 * convention requires.
 */
class AttentionWidget extends Widget
{
    protected static ?int $sort = 1;
    public const string CACHE_KEY = 'backoffice.dashboard.attention';

    public const int CACHE_SECONDS = 600;

    protected string $view = 'filament.admin.widgets.attention';

    protected int|string|array $columnSpan = ['lg' => 2];

    /** @return array<int, array{label: string, description: string, icon: string, count: int, url: string}> */
    public function queues(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_SECONDS, function (): array {
            $rows = [];

            foreach ($this->findingsPages() as $pageClass) {
                $fix = app($pageClass::fix());

                if (! $fix instanceof ReportsFindings) {
                    continue;
                }

                $icon = $pageClass::getNavigationIcon();

                $rows[] = [
                    'label' => $pageClass::getNavigationLabel(),
                    'description' => $fix->label(),
                    'icon' => $icon instanceof BackedEnum ? "heroicon-o-{$icon->value}" : (string) $icon,
                    'count' => $fix->findings()->count(),
                    'url' => $pageClass::getUrl(),
                ];
            }

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
