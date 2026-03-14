<?php

namespace App\Filament\Admin\Clusters\Advancements\Resources\Rovers;

use App\Filament\Admin\Clusters\Advancements\AdvancementsCluster;
use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Pages\ListRoverAdvancements;
use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Pages\ViewRoverAdvancement;
use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Schemas\RoverAdvancementForm;
use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Schemas\RoverAdvancementInfolist;
use App\Filament\Admin\Clusters\Advancements\Resources\Rovers\Tables\RoverAdvancementsTable;
use App\Models\AdvancementRover;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoverAdvancementResource extends Resource
{
    protected static ?string $model = AdvancementRover::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Star;

    protected static ?string $pluralLabel = 'Rover Advancements';

    protected static ?string $cluster = AdvancementsCluster::class;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return RoverAdvancementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RoverAdvancementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoverAdvancementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoverAdvancements::route('/'),
            'view' => ViewRoverAdvancement::route('/{record}'),
        ];
    }
}
