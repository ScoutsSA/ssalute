<?php

namespace App\Filament\General\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static ?int $sort = 0;

    protected string $view = 'filament.general.widgets.welcome';

    protected int|string|array $columnSpan = 'full';
}
