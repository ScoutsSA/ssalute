<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Events;

use App\Filament\Admin\Clusters\GroupOperations\GroupOperationsCluster;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Pages\ListEvents;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Pages\ViewEvent;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Schemas\EventForm;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Schemas\EventInfolist;
use App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Tables\EventsTable;
use App\Models\GroupEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = GroupEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $pluralLabel = 'Events';

    protected static ?string $cluster = GroupOperationsCluster::class;

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'view' => ViewEvent::route('/{record}'),
        ];
    }
}
