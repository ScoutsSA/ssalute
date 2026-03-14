<?php

namespace App\Filament\Admin\Clusters\GroupOperations\Resources\Events\Schemas;

use App\Enums\EventAway;
use App\Enums\EventFor;
use App\Enums\EventForType;
use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Models\SystemGroupEventType;
use App\Models\SystemUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Details')
                            ->schema([
                                Section::make('Event Details')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->columnSpanFull(),
                                        Textarea::make('description')
                                            ->columnSpanFull(),
                                        Select::make('eventTypeID')
                                            ->label('Event Type')
                                            ->options(fn () => SystemGroupEventType::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                        Select::make('scouterResponsible')
                                            ->label('Responsible Scouter')
                                            ->getSearchResultsUsing(fn (string $search) => SystemUser::query()->where('surname', 'like', "{$search}%")->orWhere('firstName', 'like', "{$search}%")->limit(50)->get()->pluck('name', 'id'))->getOptionLabelUsing(fn ($value) => SystemUser::find($value)?->name)
                                            ->searchable()
                                            ->required(),
                                        DatePicker::make('startDate')->label('Start Date')->required(),
                                        TextInput::make('startTime')->label('Start Time')->required(),
                                        DatePicker::make('endDate')->label('End Date')->required(),
                                        TextInput::make('endTime')->label('End Time')->required(),
                                        Toggle::make('active')->label('Active')->default(true)->inline(false),
                                        Toggle::make('approved')->label('Approved')->default(true)->inline(false),
                                        Toggle::make('nationalEvent')->label('National Event')->default(false)->inline(false),
                                        Toggle::make('noCopy')->label('No Copy')->default(false)->inline(false),
                                    ]),
                            ]),
                        Tab::make('Location')
                            ->schema([
                                Section::make('Venue')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('locationName')->label('Location Name')->columnSpanFull(),
                                        Textarea::make('locationAddress')->label('Location Address')->columnSpanFull(),
                                        TextInput::make('locationLat')->label('Latitude'),
                                        TextInput::make('locationLon')->label('Longitude'),
                                    ]),
                                Section::make('Area Association')
                                    ->columns(3)
                                    ->schema([
                                        Select::make('assocToRegion')
                                            ->label('Region')
                                            ->options(fn () => Region::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                        Select::make('assocToDistrict')
                                            ->label('District')
                                            ->options(fn () => District::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                        Select::make('assocToGroup')
                                            ->label('Group')
                                            ->options(fn () => Group::query()->orderBy('name')->pluck('name', 'id'))
                                            ->searchable()
                                            ->required(),
                                        TextInput::make('heldInDistrict')->label('Held In District ID')->numeric()->required(),
                                    ]),
                            ]),
                        Tab::make('Section Targeting')
                            ->schema([
                                Section::make('Event For')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('eventFor')
                                            ->label('Event For (Section)')
                                            ->options(EventFor::options()),
                                        Select::make('eventFor2')
                                            ->label('Event For (Type)')
                                            ->options(EventForType::options()),
                                        Select::make('eventAway')
                                            ->label('Event Away')
                                            ->options(EventAway::options()),
                                    ]),
                                Section::make('Section Assignments')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('denID')->label('Den ID')->numeric(),
                                        TextInput::make('packID')->label('Pack ID')->numeric(),
                                        TextInput::make('troopID')->label('Troop ID')->numeric(),
                                        TextInput::make('crewID')->label('Crew ID')->numeric(),
                                        TextInput::make('multiID')->label('Multi Section ID')->numeric(),
                                        TextInput::make('eventPatrolID')->label('Event Patrol ID')->numeric(),
                                    ]),
                            ]),
                        Tab::make('Parent Events')
                            ->schema([
                                Section::make('Associated Events')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('associatedToNationalEventID')->label('National Event ID')->numeric(),
                                        TextInput::make('associatedToRegionEventID')->label('Region Event ID')->numeric(),
                                        TextInput::make('associatedToDistrictEventID')->label('District Event ID')->numeric(),
                                    ]),
                            ]),
                        Tab::make('Scouting Metrics')
                            ->schema([
                                Section::make('Metrics')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('nightUnderCanvas')->label('Nights Under Canvas')->numeric(),
                                        TextInput::make('kmHike')->label('km Hike')->numeric(),
                                        TextInput::make('startAge')->label('Minimum Age')->numeric(),
                                        TextInput::make('endAge')->label('Maximum Age')->numeric(),
                                        Toggle::make('GPSTrackingRequired')->label('GPS Tracking Required')->default(false)->inline(false),
                                    ]),
                            ]),
                        Tab::make('Competition')
                            ->schema([
                                Section::make('Competition Settings')
                                    ->columns(2)
                                    ->schema([
                                        Toggle::make('competition')->label('Is Competition')->default(false)->inline(false),
                                        TextInput::make('competitionScoringFactor')->label('Scoring Factor')->numeric(),
                                        TextInput::make('competitionScoringDefaultPage')->label('Default Scoring Page')->numeric(),
                                        Toggle::make('competitionScorePrecheck')->label('Score Pre-check')->default(false)->inline(false),
                                    ]),
                            ]),
                        Tab::make('Booking')
                            ->schema([
                                Section::make('Booking Configuration')
                                    ->columns(2)
                                    ->schema([
                                        Toggle::make('bookingPossible')->label('Booking Possible')->default(false)->inline(false),
                                        Toggle::make('bookingLive')->label('Booking Live')->default(false)->inline(false),
                                        DatePicker::make('latestBookingDate')->label('Latest Booking Date'),
                                        TextInput::make('maxNrOfBookings')->label('Max Bookings')->numeric(),
                                        TextInput::make('managementEmail')->label('Management Email')->email(),
                                        Toggle::make('depositRequired')->label('Deposit Required')->default(false)->inline(false),
                                        DatePicker::make('depositRequiredDate')->label('Deposit Due Date'),
                                        DatePicker::make('paymentInFullByDate')->label('Full Payment Due Date'),
                                        Textarea::make('travelArrangements')->label('Travel Arrangements')->columnSpanFull(),
                                    ]),
                                Section::make('Banking Details')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('bankName')->label('Bank Name'),
                                        TextInput::make('bankAccountName')->label('Account Name'),
                                        TextInput::make('bankBranch')->label('Branch Name'),
                                        TextInput::make('bankCode')->label('Branch Code'),
                                        TextInput::make('bankAccountNumber')->label('Account Number'),
                                        TextInput::make('BAReferenceStart')->label('Bank Reference Start'),
                                    ]),
                            ]),
                        Tab::make('Documents & Links')
                            ->schema([
                                Section::make('Documents')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('uploadedDoc')->label('Uploaded Document Path')->columnSpanFull(),
                                        TextInput::make('permitDocLocation')->label('Permit Document Path')->columnSpanFull(),
                                        TextInput::make('planningDoc')->label('Planning Document Path')->columnSpanFull(),
                                        TextInput::make('marketingDoc')->label('Marketing Document Path')->columnSpanFull(),
                                    ]),
                                Section::make('External Links')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('surveyURL')->label('Survey URL')->url(),
                                        TextInput::make('leaderboardURL')->label('Leaderboard URL')->url(),
                                        TextInput::make('calendarURL')->label('Calendar URL')->url(),
                                    ]),
                            ]),
                        Tab::make('System')
                            ->schema([
                                Section::make('Security PINs')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('eventPSPin')->label('PS PIN')->numeric(),
                                        TextInput::make('eventTSPin')->label('TS PIN')->numeric(),
                                        TextInput::make('eventSGLPin')->label('SGL PIN')->numeric(),
                                        TextInput::make('eventDCPin')->label('DC PIN')->numeric(),
                                        TextInput::make('eventOtherDCPin')->label('Other DC PIN')->numeric(),
                                    ]),
                                Section::make('System Fields')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('uniqueID')->label('Unique ID')->columnSpanFull(),
                                        TextInput::make('addedIn')->label('Added In'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
