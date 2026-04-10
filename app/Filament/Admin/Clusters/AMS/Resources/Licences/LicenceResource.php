<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Licences;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\Licences\Pages\ListLicences;
use App\Filament\Admin\Clusters\AMS\Resources\Licences\Pages\ViewLicence;
use App\Filament\Admin\Clusters\AMS\Resources\Licences\Schemas\LicenceForm;
use App\Filament\Admin\Clusters\AMS\Resources\Licences\Schemas\LicenceInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\Licences\Tables\LicencesTable;
use App\Models\AmsLicenceInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LicenceResource extends Resource
{
    protected static ?string $model = AmsLicenceInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Scale;

    protected static ?string $recordTitleAttribute = 'chargeNr';

    protected static ?string $pluralLabel = 'Licences';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return LicenceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LicenceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LicencesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLicences::route('/'),
            'view' => ViewLicence::route('/{record}'),
        ];
    }
}
