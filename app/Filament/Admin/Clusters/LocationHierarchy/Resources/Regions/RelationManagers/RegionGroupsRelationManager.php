<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Regions\RelationManagers;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\GroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class RegionGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';

    protected static ?string $relatedResource = GroupResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
