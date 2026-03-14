<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Meerkats;

use App\Filament\Admin\Clusters\Advancements\AdvancementsCluster;
use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Pages\ListMeerkatAdvancements;
use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Pages\ViewMeerkatAdvancement;
use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Schemas\MeerkatAdvancementForm;
use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Schemas\MeerkatAdvancementInfolist;
use App\Filament\Admin\Clusters\Advancements\Resources\Meerkats\Tables\MeerkatAdvancementsTable;
use App\Models\AdvancementMeerkat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MeerkatAdvancementResource extends Resource
{
    protected static ?string $model = AdvancementMeerkat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static ?string $pluralLabel = 'Meerkat Advancements';

    protected static ?string $cluster = AdvancementsCluster::class;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MeerkatAdvancementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MeerkatAdvancementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeerkatAdvancementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeerkatAdvancements::route('/'),
            'view' => ViewMeerkatAdvancement::route('/{record}'),
        ];
    }
}
