<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Scouts;

use App\Filament\Admin\Clusters\Advancements\AdvancementsCluster;
use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Pages\ListScoutAdvancements;
use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Pages\ViewScoutAdvancement;
use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Schemas\ScoutAdvancementForm;
use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Schemas\ScoutAdvancementInfolist;
use App\Filament\Admin\Clusters\Advancements\Resources\Scouts\Tables\ScoutAdvancementsTable;
use App\Models\AdvancementScout;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ScoutAdvancementResource extends Resource
{
    protected static ?string $model = AdvancementScout::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static ?string $pluralLabel = 'Scout Advancements';

    protected static ?string $cluster = AdvancementsCluster::class;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ScoutAdvancementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ScoutAdvancementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScoutAdvancementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScoutAdvancements::route('/'),
            'view' => ViewScoutAdvancement::route('/{record}'),
        ];
    }
}
