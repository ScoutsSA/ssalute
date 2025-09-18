<?php

namespace App\Filament\Admin\Clusters\Area\Resources\Districts\RelationManagers;

use App\Filament\Admin\Clusters\Area\Resources\Groups\GroupResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class DistrictGroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';

    protected static ?string $relatedResource = GroupResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([]);
    }
}
