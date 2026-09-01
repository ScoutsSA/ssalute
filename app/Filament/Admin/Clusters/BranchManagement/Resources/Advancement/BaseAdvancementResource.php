<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement;

use App\Filament\Admin\Clusters\BranchManagement\BranchManagementCluster;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Schemas\AdvancementLevelForm;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Schemas\AdvancementLevelInfolist;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Advancement\Tables\AdvancementLevelsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

abstract class BaseAdvancementResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowTrendingUp;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Advancement';

    protected static ?string $cluster = BranchManagementCluster::class;

    public static function form(Schema $schema): Schema
    {
        return AdvancementLevelForm::configure($schema, static::levelExtraFormFields());
    }

    public static function infolist(Schema $schema): Schema
    {
        return AdvancementLevelInfolist::configure($schema, static::levelExtraInfolistEntries());
    }

    public static function table(Table $table): Table
    {
        return AdvancementLevelsTable::configure($table, static::getModel(), static::levelExtraTableColumns());
    }

    /** @return array<int, \Filament\Schemas\Components\Component> */
    protected static function levelExtraFormFields(): array
    {
        return [];
    }

    /** @return array<int, \Filament\Schemas\Components\Component> */
    protected static function levelExtraInfolistEntries(): array
    {
        return [];
    }

    /** @return array<int, \Filament\Tables\Columns\Column> */
    protected static function levelExtraTableColumns(): array
    {
        return [];
    }
}
