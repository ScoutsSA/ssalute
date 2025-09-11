<?php

namespace App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\Pages;

use App\Filament\Admin\Clusters\LocationHierarchy\Resources\Groups\GroupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;
}
