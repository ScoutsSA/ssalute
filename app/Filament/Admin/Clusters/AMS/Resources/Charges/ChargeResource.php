<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Charges;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\Pages\ListCharges;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\Pages\ViewCharge;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\Schemas\ChargeForm;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\Schemas\ChargeInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\Charges\Tables\ChargesTable;
use App\Models\AmsChargeInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChargeResource extends Resource
{
    protected static ?string $model = AmsChargeInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Scale;

    protected static ?string $recordTitleAttribute = 'chargeNr';

    protected static ?string $pluralLabel = 'Charges';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return ChargeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ChargeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChargesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCharges::route('/'),
            'view' => ViewCharge::route('/{record}'),
        ];
    }
}
