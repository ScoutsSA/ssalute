<?php

namespace App\Filament\Member\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static ?int $sort = 0;

    protected string $view = 'filament.member.widgets.welcome';

    protected int|string|array $columnSpan = 'full';
}
