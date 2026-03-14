<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Programs;

use App\Filament\Admin\Clusters\GroupOperations\GroupOperationsCluster;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Pages\ListPrograms;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Pages\ViewProgram;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Schemas\ProgramForm;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Schemas\ProgramInfolist;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Programs\Tables\ProgramsTable;
use App\Models\GroupProgram;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = GroupProgram::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $pluralLabel = 'Programs';

    protected static ?string $cluster = GroupOperationsCluster::class;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ProgramForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProgramInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProgramsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPrograms::route('/'),
            'view' => ViewProgram::route('/{record}'),
        ];
    }
}
