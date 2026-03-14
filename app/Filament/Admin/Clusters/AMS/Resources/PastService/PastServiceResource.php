<?php

namespace App\Filament\Admin\Clusters\AMS\Resources\PastService;

use App\Filament\Admin\Clusters\AMS\AmsCluster;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\Pages\ListPastServiceRecords;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\Pages\ViewPastServiceRecord;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\Schemas\PastServiceForm;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\Schemas\PastServiceInfolist;
use App\Filament\Admin\Clusters\AMS\Resources\PastService\Tables\PastServiceTable;
use App\Models\AmsPastServiceInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PastServiceResource extends Resource
{
    protected static ?string $model = AmsPastServiceInfo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    protected static ?string $pluralLabel = 'Past Service Records';

    protected static ?string $cluster = AmsCluster::class;

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return PastServiceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PastServiceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PastServiceTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPastServiceRecords::route('/'),
            'view' => ViewPastServiceRecord::route('/{record}'),
        ];
    }
}
