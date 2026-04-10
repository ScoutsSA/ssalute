<?php

namespace App\Filament\Shared\Navigation;

use App\Filament\Member\Resources\Profile\ProfileResource;
use Filament\Navigation\NavigationItem;
use Filament\Support\Icons\Heroicon;

class NavigationItems
{
    public static function myProfile(string $panel): NavigationItem
    {
        return NavigationItem::make('My Profile')
            ->icon(Heroicon::UserCircle)
            ->group('My Info')
            ->sort(1)
            ->url(fn () => ProfileResource::getUrl('view', ['record' => auth()->id()], panel: $panel))
            ->isActiveWhen(fn () => request()->routeIs("filament.{$panel}.resources.profile.*"));
    }

    /**
     * @return array<NavigationItem>
     */
    public static function externalLinks(): array
    {
        return [
            NavigationItem::make('Scouts Digital')
                ->icon(Heroicon::GlobeAlt)
                ->group('External Links')
                ->sort(1)
                ->url('https://ssa.scouts.digital', shouldOpenInNewTab: true),
            NavigationItem::make('Permit System')
                ->icon(Heroicon::ClipboardDocumentCheck)
                ->group('External Links')
                ->sort(2)
                ->url('https://permits.scouts.org.za', shouldOpenInNewTab: true),
            NavigationItem::make('Scout Wiki')
                ->icon(Heroicon::BookOpen)
                ->group('External Links')
                ->sort(3)
                ->url('https://scoutwiki.scouts.org.za/wiki/SCOUTS_South_Africa_Wiki', shouldOpenInNewTab: true),
            NavigationItem::make('National Website')
                ->icon(Heroicon::BuildingOffice)
                ->group('External Links')
                ->sort(4)
                ->url('https://www.scouts.org.za/', shouldOpenInNewTab: true),
            NavigationItem::make('Alumni')
                ->icon(Heroicon::AcademicCap)
                ->group('External Links')
                ->sort(5)
                ->url('https://www.scouts.org.za/get-involved/scouts-sa-alumni/', shouldOpenInNewTab: true),
            NavigationItem::make('General Support')
                ->icon(Heroicon::Lifebuoy)
                ->group('External Links')
                ->sort(6)
                ->url('https://support.scouts.org.za/', shouldOpenInNewTab: true),
            NavigationItem::make('Donations')
                ->icon(Heroicon::Heart)
                ->group('External Links')
                ->sort(7)
                ->url('https://www.scoutfoundation.org.za/donate/#monthly-donation-options', shouldOpenInNewTab: true),
            NavigationItem::make('Slack Group')
                ->icon(Heroicon::ChatBubbleLeftRight)
                ->group('External Links')
                ->sort(8)
                ->url('https://join.slack.com/t/scoutssa/shared_invite/zt-3ss7zpgqa-UkqirUjoLRX9jd8R0lpu~w', shouldOpenInNewTab: true),
        ];
    }
}
