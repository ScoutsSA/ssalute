<?php

namespace App\Filament\Admin\Clusters\DataFixes\Pages;

use App\Filament\Admin\Clusters\DataFixes\DataFixesCluster;
use App\Services\SystemFixes\ReportsFindings;
use App\Services\SystemFixes\SystemFixFinding;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

/**
 * One fix's outstanding items, as a table an admin can act from.
 *
 * Rows are measured when the page loads rather than read from the last nightly run, so an item
 * somebody has just corrected is gone on refresh. Subclasses supply the fix; everything else —
 * the columns, the link action, the empty state — is the same for every fix by design, because
 * the Slack alert links here and should land somewhere predictable.
 */
abstract class FindingsPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $cluster = DataFixesCluster::class;

    protected string $view = 'filament.admin.clusters.data-fixes.findings';

    /**
     * These tables carry long free-text detail alongside three other columns, so the default
     * centred column wastes most of the screen and wraps the part an admin is reading.
     */
    protected Width|string|null $maxContentWidth = Width::Full;

    /**
     * What the rows represent, used in the empty state.
     */
    protected static function subject(): string
    {
        return 'items';
    }

    /**
     * @return class-string<ReportsFindings>
     */
    abstract public static function fix(): string;

    public function table(Table $table): Table
    {
        $solve = $this->solveAction();

        return $table
            ->records(fn (): Collection => $this->findings())
            ->columns([
                TextColumn::make('title')
                    ->label('Record')
                    ->weight('medium')
                    ->searchable(),
                TextColumn::make('detail')
                    ->label('What needs attention')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('badge')
                    ->label('Value')
                    ->badge()
                    ->color('warning')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('group')
                    ->label('Area')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
            ])
            ->striped()
            // Where a fix can be resolved in place, the whole row opens that action — these are
            // worklists, and the row IS the thing you act on. Where a fix has no in-place
            // resolution yet, the row is inert rather than carrying a button that only navigates.
            ->recordActions($solve instanceof Action ? [$solve] : [])
            ->recordAction($solve?->getName())
            ->emptyStateHeading('Nothing outstanding')
            ->emptyStateDescription('No ' . static::subject() . ' need attention right now.')
            ->emptyStateIcon(Heroicon::CheckCircle)
            ->paginated([25, 50, 100]);
    }

    /**
     * The action that resolves one of this fix's findings in place, if there is one.
     *
     * Returning an action makes the entire row trigger it. Returning null leaves the rows inert:
     * a button that only navigates away is not worth a column, and the finding's detail already
     * names the record.
     */
    protected function solveAction(): ?Action
    {
        return null;
    }

    /**
     * @return Collection<int|string, array<string, string|null|int>>
     */
    protected function findings(): Collection
    {
        return app(static::fix())
            ->findings()
            ->values()
            ->mapWithKeys(fn (SystemFixFinding $finding, int $index): array => [
                $index => [
                    'id' => $index,
                    'title' => $finding->title,
                    'detail' => $finding->detail,
                    'group' => $finding->group,
                    'url' => $finding->url,
                    'linkLabel' => $finding->linkLabel,
                    'recordId' => $finding->recordId,
                    'badge' => $finding->badge,
                ],
            ]);
    }
}
