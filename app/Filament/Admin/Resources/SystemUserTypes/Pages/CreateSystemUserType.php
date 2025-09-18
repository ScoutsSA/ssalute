<?php

namespace App\Filament\Admin\Resources\SystemUserTypes\Pages;

use App\Filament\Admin\Resources\SystemUserTypes\SystemUserTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSystemUserType extends CreateRecord
{
    protected static string $resource = SystemUserTypeResource::class;
}
