<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\Widget;

class WhatsNewWidget extends Widget
{
    protected static ?int $sort = 99;

    protected string $view = 'filament.member.widgets.whats-new';

    protected int|string|array $columnSpan = 'full';
}
