<?php

namespace App\Filament\Concerns;

use App\Models\Audit;
use STS\FilamentImpersonate\Facades\Impersonation;

trait AuditsSettings
{
    protected ?array $oldSettingsValues = null;

    protected function beforeSave(): void
    {
        $settings = app(static::getSettings());
        $this->oldSettingsValues = $settings->toArray();
    }

    protected function afterSave(): void
    {
        $settings = app(static::getSettings());
        $newValues = $settings->toArray();
        $oldValues = $this->oldSettingsValues ?? [];

        $changed = [];
        $original = [];

        foreach ($newValues as $key => $value) {
            $old = $oldValues[$key] ?? null;

            if ($old !== $value) {
                $changed[$key] = $value;
                $original[$key] = $old;
            }
        }

        if (empty($changed) || ! auth()->check()) {
            return;
        }

        Audit::create([
            'user_type' => get_class(auth()->user()),
            'user_id' => auth()->id(),
            'event' => 'updated',
            'auditable_type' => static::getSettings(),
            'auditable_id' => 0,
            'old_values' => $original,
            'new_values' => $changed,
            'url' => request()->header('Referer', request()->fullUrl()),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'tags' => Impersonation::isImpersonating()
                ? 'impersonated_by:' . Impersonation::getImpersonatorId()
                : null,
        ]);
    }
}
