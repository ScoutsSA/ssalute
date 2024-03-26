<?php

namespace App\Models\V3;

use Illuminate\Database\Eloquent\Model;

class V3Permission extends Model
{
    public const LEGACY_CAN_ADMIN_ALUMNI = 'CAN_ADMIN_ALUMNI';
    public const LEGACY_CAN_SEE_ALUMNI = 'CAN_SEE_ALUMNI';
    public const LEGACY_CAN_ADMIN_NATIONAL = 'CAN_ADMIN_NATIONAL';
    public const LEGACY_CAN_SEE_NATIONAL = 'CAN_SEE_NATIONAL';
    public const LEGACY_CAN_ADMIN_REGION = 'CAN_ADMIN_REGION';
    public const LEGACY_CAN_SEE_REGION = 'CAN_SEE_REGION';
    public const LEGACY_CAN_ADMIN_REGION_KIDS = 'CAN_ADMIN_REGION_KIDS';
    public const LEGACY_CAN_ADMIN_REGION_TRAINING = 'CAN_ADMIN_REGION_TRAINING';
    public const LEGACY_CAN_ADMIN_SUPER_DISTRICT = 'CAN_ADMIN_SUPER_DISTRICT';
    public const LEGACY_CAN_SEE_SUPER_DISTRICT = 'CAN_SEE_SUPER_DISTRICT';
    public const LEGACY_CAN_ADMIN_DISTRICT = 'CAN_ADMIN_DISTRICT';
    public const LEGACY_CAN_SEE_DISTRICT = 'CAN_SEE_DISTRICT';
    public const LEGACY_CAN_ADMIN_DISTRICT_KIDS = 'CAN_ADMIN_DISTRICT_KIDS';
    public const LEGACY_CAN_ADMIN_GROUP = 'CAN_ADMIN_GROUP';
    public const LEGACY_CAN_SEE_GROUP = 'CAN_SEE_GROUP';
    public const LEGACY_CAN_ADMIN_GROUP_ADULTS = 'CAN_ADMIN_GROUP_ADULTS';
    public const LEGACY_CAN_AWARD_GROUP_MEERKATS = 'CAN_AWARD_GROUP_MEERKATS';
    public const LEGACY_CAN_AWARD_GROUP_CUBS = 'CAN_AWARD_GROUP_CUBS';
    public const LEGACY_CAN_AWARD_GROUP_SCOUTS = 'CAN_AWARD_GROUP_SCOUTS';
    public const LEGACY_CAN_AWARD_GROUP_ROVERS = 'CAN_AWARD_GROUP_ROVERS';
    public const LEGACY_CAN_SEE_SUPPORT = 'CAN_SEE_SUPPORT';
    public const LEGACY_CAN_ADMIN_SUPPORT = 'CAN_ADMIN_SUPPORT';
    public const LEGACY_CAN_ADD_WARRANTS = 'CAN_ADD_WARRANTS';
    public const LEGACY_CAN_ADMIN_PROPERTY = 'CAN_ADMIN_PROPERTY';
    public const LEGACY_CAN_SIGN_WARRANTS = 'CAN_SIGN_WARRANTS';
    public const LEGACY_CAN_ADMIN_FORM29 = 'CAN_ADMIN_FORM29';
    public const LEGACY_CAN_ADMIN_POLICE_CLEARANCE = 'CAN_ADMIN_POLICE_CLEARANCE';


    protected $connection = 'v3_core';
    protected $table = 'permissions';
    protected $guarded = [];

    protected $casts = [
        'system_name' => 'string',
        'display_name' => 'string',
        'description' => 'string',
    ];
}
