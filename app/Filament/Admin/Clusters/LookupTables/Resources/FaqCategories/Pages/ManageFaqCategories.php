<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\Pages;

use App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\FaqCategoryResource;
use App\Models\SystemFaqCat;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ManageFaqCategories extends ManageRecords
{
    protected static string $resource = FaqCategoryResource::class;

    /**
     * Positions are scoped per audience in the legacy app (every audience list
     * starts at 1), so renumber within each audience instead of globally.
     */
    public function reorderTable(array $order, int|string|null $draggedRecordKey = null): void
    {
        if (! $this->getTable()->isReorderable()) {
            return;
        }

        $records = SystemFaqCat::query()->whereIn('id', $order)->get()->keyBy('id');

        DB::transaction(function () use ($order, $records): void {
            $nextPositionPerAudience = [];

            foreach ($order as $recordKey) {
                $record = $records->get((int) $recordKey);

                if (! $record) {
                    continue;
                }

                $audience = $record->audience;
                $nextPositionPerAudience[$audience] = ($nextPositionPerAudience[$audience] ?? 0) + 1;

                $record->update(['position' => $nextPositionPerAudience[$audience]]);
            }
        });
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * While reordering, keep the rows in their audience blocks so dragging
     * happens within the same list the grouped view shows.
     */
    protected function applySortingToTableQuery(Builder $query): Builder
    {
        if ($this->isTableReordering()) {
            return $query
                ->orderByRaw(FaqCategoryResource::audienceOrderExpression())
                ->orderBy('position');
        }

        return parent::applySortingToTableQuery($query);
    }
}
