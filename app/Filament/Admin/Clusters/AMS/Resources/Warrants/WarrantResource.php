<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Warrants;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\Pages\ListWarrants;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\Pages\ViewWarrant;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\Schemas\WarrantForm;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\Schemas\WarrantInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\Warrants\Tables\WarrantsTable;
use App\Models\AmsWarrantInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WarrantResource extends Resource
{
    protected static ?string $model = AmsWarrantInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCheck;

    protected static ?string $recordTitleAttribute = 'warrantNr';

    protected static ?string $pluralLabel = 'Warrants';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return WarrantForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WarrantInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarrantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWarrants::route('/'),
            'view' => ViewWarrant::route('/{record}'),
        ];
    }
}
