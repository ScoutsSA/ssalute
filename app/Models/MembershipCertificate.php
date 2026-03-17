<?php

namespace App\Models;

use App\Models\Concerns\IsAuditable;
use App\Settings\FeatureSettings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class MembershipCertificate extends Model implements Auditable
{
    use HasFactory;
    use IsAuditable;

    protected $fillable = [
        'user_id',
        'visible_fields',
    ];

    /**
     * Check if a user has eligible active roles for the membership certificate.
     *
     * @param  Collection<int, SystemUsersOtherRole>  $activeAttachments
     */
    public static function userHasEligibleRoles(Collection $activeAttachments): bool
    {
        if ($activeAttachments->isEmpty()) {
            return false;
        }

        $eligibleRoleIds = resolve(FeatureSettings::class)->membership_certificate_eligible_role_ids ?? [];

        if (! empty($eligibleRoleIds)) {
            return $activeAttachments->contains(fn (SystemUsersOtherRole $attachment) => in_array($attachment->roleID, $eligibleRoleIds));
        }

        return $activeAttachments->contains(function (SystemUsersOtherRole $attachment) {
            $role = $attachment->role;

            if (! $role) {
                return false;
            }

            return $role->parentHelperRole !== 1 && $role->alumniRole !== 1;
        });
    }

    protected static function booted(): void
    {
        static::creating(function (self $certificate) {
            $certificate->uuid ??= Str::uuid()->toString();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'user_id');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    protected function casts(): array
    {
        return [
            'visible_fields' => 'array',
        ];
    }
}
