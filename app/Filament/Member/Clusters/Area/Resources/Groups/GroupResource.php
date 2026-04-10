<?php

namespace App\Filament\Member\Clusters\Area\Resources\Groups;

use App\Filament\Member\Clusters\Area\AreaCluster;
use App\Filament\Member\Clusters\Area\Resources\Groups\Pages\ListGroups;
use App\Filament\Member\Clusters\Area\Resources\Groups\Pages\ViewGroup;
use App\Filament\Member\Clusters\Area\Resources\Groups\Schemas\GroupInfolist;
use App\Filament\Member\Clusters\Area\Resources\Groups\Tables\GroupsTable;
use App\Models\Group;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $cluster = AreaCluster::class;

    protected static ?int $navigationSort = 3;

    protected static bool $isScopedToTenant = false;

    public static function infolist(Schema $schema): Schema
    {
        return GroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'view' => ViewGroup::route('/{record}'),
        ];
    }
}
