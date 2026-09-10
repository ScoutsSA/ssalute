<?php

namespace App\Models;

use App\Enums\DirectoryLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One message an adult leader sent through the system to a member who redacted their contact
 * details. Kept as a record of who contacted whom, and when, from the member directory.
 */
class SystemContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_user_id',
        'sender_role_attachment_id',
        'recipient_user_id',
        'recipient_role_attachment_id',
        'directory_level',
        'subject',
        'message',
        'sent_at',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'sender_user_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(SystemUser::class, 'recipient_user_id');
    }

    public function senderRoleAttachment(): BelongsTo
    {
        return $this->belongsTo(SystemUsersOtherRole::class, 'sender_role_attachment_id');
    }

    public function recipientRoleAttachment(): BelongsTo
    {
        return $this->belongsTo(SystemUsersOtherRole::class, 'recipient_role_attachment_id');
    }

    protected function casts(): array
    {
        return [
            'id' => 'int',
            'sender_user_id' => 'int',
            'sender_role_attachment_id' => 'int',
            'recipient_user_id' => 'int',
            'recipient_role_attachment_id' => 'int',
            'directory_level' => DirectoryLevel::class,
            'subject' => 'string',
            'message' => 'string',
            'sent_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
