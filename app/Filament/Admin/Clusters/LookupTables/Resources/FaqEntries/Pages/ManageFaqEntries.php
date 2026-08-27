<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\FaqEntries\FaqEntryResource;
use App\Models\SystemFaq;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Width;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ManageFaqEntries extends ManageRecords
{
    protected static string $resource = FaqEntryResource::class;

    /**
     * Positions are scoped per category in the legacy app (every category list
     * starts at 1), so renumber within each category instead of globally.
     */
    public function reorderTable(array $order, int|string|null $draggedRecordKey = null): void
    {
        if (! $this->getTable()->isReorderable()) {
            return;
        }

        $records = SystemFaq::query()->whereIn('id', $order)->get()->keyBy('id');

        DB::transaction(function () use ($order, $records): void {
            $nextPositionPerCategory = [];

            foreach ($order as $recordKey) {
                $record = $records->get((int) $recordKey);

                if (! $record) {
                    continue;
                }

                $categoryId = $record->catID;
                $nextPositionPerCategory[$categoryId] = ($nextPositionPerCategory[$categoryId] ?? 0) + 1;

                $record->update(['position' => $nextPositionPerCategory[$categoryId]]);
            }
        });
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(Width::SevenExtraLarge),
        ];
    }

    /**
     * While reordering, keep the rows in their category blocks so dragging
     * happens within one category list at a time.
     */
    protected function applySortingToTableQuery(Builder $query): Builder
    {
        if ($this->isTableReordering()) {
            return $query
                ->orderBy('catID')
                ->orderBy('position');
        }

        return parent::applySortingToTableQuery($query);
    }
}
