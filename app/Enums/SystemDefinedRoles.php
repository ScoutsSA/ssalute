<?php

namespace App\Enums;

enum SystemDefinedRoles: string
{
    case NationalAdultSupport = 'Chair: National Adult Support';

    case RegionalAdultSupportCoordinator = 'Regional Team Coordinator: Adult Support';
    case RegionalAdultSupportTeamMember = 'Support Team Member: Adult Support';
    case RegionalAdultSupportTeamMemberGroup = 'Support Team Member: Groups';

    case DistrictCommissioner = 'District Commissioner';
    case DistrictManager = 'Scouts.Digital District Manager';
    case DistrictGroupManager = 'Scouts Digital District Group Administrator';

    case ScoutGroupLeader = 'Scout Group Leader';
}
