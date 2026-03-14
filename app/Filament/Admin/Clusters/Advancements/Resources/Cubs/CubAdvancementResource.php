<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Cubs;

use App\Filament\Admin\Clusters\Advancements\AdvancementsCluster;
use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Pages\ListCubAdvancements;
use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Pages\ViewCubAdvancement;
use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Schemas\CubAdvancementForm;
use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Schemas\CubAdvancementInfolist;
use App\Filament\Admin\Clusters\Advancements\Resources\Cubs\Tables\CubAdvancementsTable;
use App\Models\AdvancementCub;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CubAdvancementResource extends Resource
{
    protected static ?string $model = AdvancementCub::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static ?string $pluralLabel = 'Cub Advancements';

    protected static ?string $cluster = AdvancementsCluster::class;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return CubAdvancementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CubAdvancementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CubAdvancementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCubAdvancements::route('/'),
            'view' => ViewCubAdvancement::route('/{record}'),
        ];
    }
}
