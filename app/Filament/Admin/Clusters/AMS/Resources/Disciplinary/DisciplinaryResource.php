<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Disciplinary;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Pages\ListDisciplinaryRecords;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Pages\ViewDisciplinaryRecord;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Schemas\DisciplinaryForm;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Schemas\DisciplinaryInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\Disciplinary\Tables\DisciplinaryTable;
use App\Models\AmsDisciplinaryInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DisciplinaryResource extends Resource
{
    protected static ?string $model = AmsDisciplinaryInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ExclamationTriangle;

    protected static ?string $pluralLabel = 'Disciplinary Records';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return DisciplinaryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DisciplinaryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DisciplinaryTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDisciplinaryRecords::route('/'),
            'view' => ViewDisciplinaryRecord::route('/{record}'),
        ];
    }
}
