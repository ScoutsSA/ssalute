<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

use App\Services\Areas\AreaDeletionGuard;
use Filament\Facades\Filament;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 * Read only tab listing the rows of one legacy table that reference the owning region, district or group.
 *
 * Subclasses are generated from AreaReferenceMap and only set the relationship, table and title.
 * The tab is hidden when the table holds no rows for the record, so an unused area shows none of them.
 */
abstract class LinkedRecordsRelationManager extends RelationManager
{
    protected static string $linkedTable = '';

    /** @var list<string> */
    protected const CANDIDATE_COLUMNS = [
        'name', 'title', 'first_name', 'surname', 'username', 'description', 'type', 'status',
        'date', 'userID', 'active', 'created', 'createdby',
    ];

    public static function getLinkedTable(): string
    {
        return static::$linkedTable;
    }

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        $blockers = resolve(AreaDeletionGuard::class)->blockersFor($ownerRecord);

        if (($blockers[static::$linkedTable] ?? 0) === 0) {
            return false;
        }

        return $ownerRecord->{static::getRelationshipName()}()->exists();
    }

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        return (string) $ownerRecord->{static::getRelationshipName()}()->count();
    }

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        $related = $this->getOwnerRecord()->{static::getRelationshipName()}()->getRelated();
        $resource = Filament::getModelResource($related::class);

        return $table
            ->columns($this->columnsFor($related))
            ->defaultSort($related->getKeyName(), 'desc')
            ->paginated([10, 25, 50])
            ->recordUrl(function (Model $record) use ($resource): ?string {
                if ($resource === null) {
                    return null;
                }

                if ($resource::hasPage('view')) {
                    return $resource::getUrl('view', ['record' => $record]);
                }

                if ($resource::hasPage('edit')) {
                    return $resource::getUrl('edit', ['record' => $record]);
                }

                return null;
            });
    }

    /**
     * @return list<TextColumn|IconColumn>
     */
    protected function columnsFor(Model $related): array
    {
        $casts = $related->getCasts();

        $columns = [
            TextColumn::make($related->getKeyName())
                ->label('ID')
                ->sortable()
                ->toggleable(),
        ];

        foreach (self::CANDIDATE_COLUMNS as $column) {
            if (! array_key_exists($column, $casts) || $column === $related->getKeyName()) {
                continue;
            }

            $columns[] = match (true) {
                $casts[$column] === 'bool' => IconColumn::make($column)->boolean()->sortable()->toggleable(),
                in_array($casts[$column], ['datetime', 'date'], true) => TextColumn::make($column)->dateTime()->sortable()->toggleable(),
                default => TextColumn::make($column)->limit(60)->sortable()->toggleable(),
            };
        }

        return $columns;
    }
}
