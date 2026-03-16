<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\Widget;

class BetaWarningWidget extends Widget
{
    protected static ?int $sort = -1;

    protected string $view = 'filament.admin.widgets.beta-warning';

    protected int|string|array $columnSpan = 'full';
}
