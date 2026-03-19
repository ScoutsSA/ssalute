<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\Awards;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\Awards\Pages\ListAwards;
use App\Filament\Admin\Clusters\AMS\Resources\Awards\Pages\ViewAward;
use App\Filament\Admin\Clusters\AMS\Resources\Awards\Schemas\AwardForm;
use App\Filament\Admin\Clusters\AMS\Resources\Awards\Schemas\AwardInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\Awards\Tables\AwardsTable;
use App\Models\Award;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AwardResource extends Resource
{
    protected static ?string $model = Award::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Trophy;

    protected static ?string $recordTitleAttribute = 'awardDate';

    protected static ?string $pluralLabel = 'Awards';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return AwardForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AwardInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AwardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAwards::route('/'),
            'view' => ViewAward::route('/{record}'),
        ];
    }
}
