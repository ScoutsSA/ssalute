<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Training;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\Training\Pages\ListTrainingRecords;
use App\Filament\Admin\Clusters\AMS\Resources\Training\Pages\ViewTrainingRecord;
use App\Filament\Admin\Clusters\AMS\Resources\Training\Schemas\TrainingForm;
use App\Filament\Admin\Clusters\AMS\Resources\Training\Schemas\TrainingInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\Training\Tables\TrainingTable;
use App\Models\PastTraining;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrainingResource extends Resource
{
    protected static ?string $model = PastTraining::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $pluralLabel = 'Training History';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return TrainingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrainingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingRecords::route('/'),
            'view' => ViewTrainingRecord::route('/{record}'),
        ];
    }
}
