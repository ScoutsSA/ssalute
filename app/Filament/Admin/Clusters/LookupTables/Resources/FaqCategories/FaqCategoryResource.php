<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\FaqCategories\Pages\ManageFaqCategories;
use App\Models\SystemFaqCat;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class FaqCategoryResource extends Resource
{
    protected static ?string $model = SystemFaqCat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    protected static ?string $pluralLabel = 'FAQ Categories';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 130;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Support';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            Textarea::make('description')->label('Description')->columnSpanFull(),
            TextInput::make('faqGroup')->label('FAQ Group')->numeric()->required()->default(0)->helperText('Legacy grouping number. Existing categories use groups 0 to 4; the legacy admin screen always writes 0.'),
            TextInput::make('position')->label('Position')->numeric()->required()->default(0),
            Toggle::make('forNational')->label('For National')->inline(false),
            Toggle::make('forRegion')->label('For Region')->inline(false),
            Toggle::make('forDistrict')->label('For District')->inline(false),
            Toggle::make('forGroupAdults')->label('For Group Adults')->inline(false),
            Toggle::make('forGroupParents')->label('For Group Parents')->inline(false),
            Toggle::make('forGroupScouts')->label('For Group Scouts')->inline(false),
            Toggle::make('forGroupRovers')->label('For Group Rovers')->inline(false),
            Toggle::make('forAlumni')->label('For Alumni')->inline(false),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->reorderable('position')
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: categories for the FAQ module. They drive the FAQ navigation, search and admin screens, and the audience flags control which roles see each category. The legacy pages only show rows with FAQ group 0 and exactly one audience flag; rows without a flag belong to the retired FAQ group mechanism and are not displayed anywhere.')
            ->filters([
                SelectFilter::make('audience')
                    ->label('Displayed To')
                    ->options(SystemFaqCat::AUDIENCE_FLAGS + ['none' => 'Not Displayed'])
                    ->query(function (Builder $query, array $data): Builder {
                        $value = $data['value'] ?? null;

                        if (blank($value)) {
                            return $query;
                        }

                        if ($value === 'none') {
                            foreach (array_keys(SystemFaqCat::AUDIENCE_FLAGS) as $column) {
                                $query->where($column, 0);
                            }

                            return $query;
                        }

                        return $query->where($value, 1);
                    }),
            ])
            ->groups([static::audienceGroup()])
            ->defaultGroup(static::audienceGroup())
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable()->toggleable(),
                TextColumn::make('audience')->label('Displayed To')->state(fn (SystemFaqCat $record): string => $record->audience)->toggleable(),
                TextColumn::make('position')->label('Position')->sortable()->toggleable(),
                TextColumn::make('faqGroup')->label('FAQ Group')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('description')->label('Description')->limit(60)->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forNational')->label('National')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forRegion')->label('Region')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forDistrict')->label('District')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forGroupAdults')->label('Group Adults')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forGroupParents')->label('Group Parents')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forGroupScouts')->label('Group Scouts')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forGroupRovers')->label('Group Rovers')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('forAlumni')->label('Alumni')->boolean()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
            ])
            ->defaultSort('position');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageFaqCategories::route('/'),
        ];
    }

    protected static function audienceGroup(): Group
    {
        return Group::make('audience')
            ->label('Displayed To')
            ->getTitleFromRecordUsing(fn (SystemFaqCat $record): string => $record->audience)
            ->getKeyFromRecordUsing(fn (SystemFaqCat $record): string => $record->audience)
            ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderByRaw(
                'CASE
                    WHEN forNational = 1 THEN 1
                    WHEN forRegion = 1 THEN 2
                    WHEN forDistrict = 1 THEN 3
                    WHEN forGroupAdults = 1 THEN 4
                    WHEN forGroupParents = 1 THEN 5
                    WHEN forGroupScouts = 1 THEN 6
                    WHEN forGroupRovers = 1 THEN 7
                    WHEN forAlumni = 1 THEN 8
                    ELSE 9
                END ' . ($direction === 'desc' ? 'desc' : 'asc'),
            ));
    }
}
