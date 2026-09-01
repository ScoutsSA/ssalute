<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * Six columns so the KPI block (4) and the attention queue (2) share the
     * first row, and the two activity tables split the second row evenly.
     */
    public function getColumns(): int|array
    {
        return ['default' => 1, 'lg' => 6];
    }
}
