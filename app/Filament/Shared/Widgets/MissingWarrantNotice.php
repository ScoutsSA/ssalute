<?php

namespace App\Filament\Shared\Widgets;

use App\Models\SystemUsersOtherRole;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class MissingWarrantNotice extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.holding-zone.widgets.missing-warrant-notice';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()
            ->roleAttachments()
            ->where('active', 1)
            ->whereHas('role', fn ($q) => $q->where('warrantedRole', '>', 0))
            ->get()
            ->contains(fn (SystemUsersOtherRole $role) => ! $role->hasValidWarrantOrAppointment());
    }

    public function getAffectedRoles(): Collection
    {
        return auth()->user()
            ->roleAttachments()
            ->where('active', 1)
            ->with(['role', 'region', 'district', 'group'])
            ->get()
            ->filter(fn (SystemUsersOtherRole $role) => $role->role->warrantedRole > 0 && ! $role->hasValidWarrantOrAppointment());
    }
}
