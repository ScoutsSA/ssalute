<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups;

use App\Filament\Admin\Clusters\LocationHierarchy\LocationHierarchyCluster;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages\CreateGroup;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages\EditGroup;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages\ListGroups;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages\ViewGroup;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Schemas\GroupForm;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Schemas\GroupInfolist;
use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Tables\GroupsTable;
use App\Models\Group;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $cluster = LocationHierarchyCluster::class;
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return GroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'view' => ViewGroup::route('/{record}'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }
}
