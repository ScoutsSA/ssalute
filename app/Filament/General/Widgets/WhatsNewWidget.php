<?php

namespace App\Filament\General\Widgets;

use Filament\Widgets\Widget;

class WhatsNewWidget extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.general.widgets.whats-new';

    protected int|string|array $columnSpan = 'full';
}
