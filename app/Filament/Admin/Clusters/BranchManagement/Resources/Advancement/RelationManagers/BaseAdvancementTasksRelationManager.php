<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\RelationManagers;

use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Tables\BadgesTable;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

abstract class BaseAdvancementTasksRelationManager extends RelationManager
{
    protected static bool $hasActiveFlag = true;

    public function form(Schema $schema): Schema
    {
        return $schema->components($this->taskFormComponents());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->reorderable('position')
            ->defaultSort('position')
            ->headerActions([
                CreateAction::make()
                    ->modalWidth(Width::SevenExtraLarge)
                    ->mutateDataUsing(function (array $data): array {
                        $relationshipName = static::getRelationshipName();
                        $data['position'] = ((int) $this->getOwnerRecord()->{$relationshipName}()->max('position')) + 1;

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()->modalWidth(Width::SevenExtraLarge),
                ...(static::$hasActiveFlag ? [
                    BadgesTable::deactivateAction()
                        ->modalDescription('The record is hidden from sign-off screens. Existing awarded records are not touched and it can be reactivated at any time.'),
                    BadgesTable::activateAction(),
                ] : []),
            ])
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('position')->sortable()->toggleable(),
                ...$this->taskTableColumns(),
                ...(static::$hasActiveFlag ? [IconColumn::make('active')->boolean()->sortable()->toggleable()] : []),
            ])
            ->filters(static::$hasActiveFlag ? [TernaryFilter::make('active')->default(true)] : []);
    }

    /** @return array<int, \Filament\Schemas\Components\Component> */
    abstract protected function taskFormComponents(): array;

    /** @return array<int, \Filament\Tables\Columns\Column> */
    abstract protected function taskTableColumns(): array;
}
