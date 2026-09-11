<?php

namespace App\Filament\Admin\Clusters\Area\Actions;

use App\Services\Areas\AreaDeletionGuard;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

/**
 * Delete action for regions, districts and groups that refuses while any table still references the record.
 */
class DeleteAreaAction extends DeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->before(function (DeleteAreaAction $action, Model $record): void {
            $guard = resolve(AreaDeletionGuard::class);
            $guard->forget($record);
            $blockers = $guard->blockersFor($record);

            if ($blockers === []) {
                return;
            }

            Notification::make()
                ->title("Cannot delete {$record->getAttribute('name')} (#{$record->getKey()})")
                ->body(AreaDeletionGuard::describe($blockers) . '. Remove or re-assign these records first. Each blocking table is listed as a tab on the record.')
                ->danger()
                ->persistent()
                ->send();

            $action->cancel();
        });
    }
}
