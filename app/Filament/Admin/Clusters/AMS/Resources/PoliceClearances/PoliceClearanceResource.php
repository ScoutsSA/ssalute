<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Pages\ListPoliceClearances;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Pages\ViewPoliceClearance;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Schemas\PoliceClearanceForm;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Schemas\PoliceClearanceInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\PoliceClearances\Tables\PoliceClearancesTable;
use App\Models\AmsPoliceClearance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PoliceClearanceResource extends Resource
{
    protected static ?string $model = AmsPoliceClearance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShieldCheck;

    protected static ?string $pluralLabel = 'Police Clearances';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return PoliceClearanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PoliceClearanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PoliceClearancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPoliceClearances::route('/'),
            'view' => ViewPoliceClearance::route('/{record}'),
        ];
    }
}
