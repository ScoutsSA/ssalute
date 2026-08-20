<?php

namespace App\Filament\Admin\Clusters\DataFixes;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Where the nightly data-integrity fixes report what they could not resolve on their own.
 *
 * One page per fix, each listing that fix's outstanding items with a link straight to the record
 * where each can be actioned. The Slack alert for a fix says only how many are outstanding and
 * links here; the detail lives on the page, where it can be clicked.
 */
class DataFixesCluster extends Cluster
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Wrench;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?string $navigationLabel = 'Data Fixes';

    protected static ?int $navigationSort = 2;
}
