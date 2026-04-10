<?php

namespace App\Filament\HoldingZone\Widgets;

use Filament\Widgets\Widget;

class AccountOverview extends Widget
{
    protected static ?int $sort = 1;

    protected string $view = 'filament.holding-zone.widgets.account-overview';

    protected int|string|array $columnSpan = 'full';
}
