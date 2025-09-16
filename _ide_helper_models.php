<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $userID
 * @property string|null $refURL
 * @property string|null $actualURL
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page whereActualURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page whereRefURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin404Page whereUserID($value)
 */
	class Admin404Page extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property \Illuminate\Support\Carbon $date
 * @property string $ip
 * @property string|null $userAgent
 * @property int|null $usingMobile
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBadLogon whereUsingMobile($value)
 */
	class AdminBadLogon extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $ip
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $page
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminBannedIp wherePage($value)
 */
	class AdminBannedIp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $username
 * @property string|null $password
 * @property \Illuminate\Support\Carbon $date
 * @property string $ip
 * @property int|null $roleID
 * @property int $fromSD
 * @property int|null $groupID
 * @property int|null $districtID
 * @property int|null $regionID
 * @property int|null $countryID
 * @property string|null $userAgent
 * @property int|null $usingMobile
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereFromSD($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminGoodLogon whereUsingMobile($value)
 */
	class AdminGoodLogon extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $cubID
 * @property int $userID
 * @property int $themeID
 * @property int $advancementID
 * @property int|null $advancementSecondID
 * @property int|null $advancementThirdID
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon|null $advancementDate
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAdvancementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAdvancementID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAdvancementSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAdvancementThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereCubID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereThemeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementCub whereUserID($value)
 */
	class AdvancementCub extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $type
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $userID
 * @property string $description
 * @property string $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $advancementFirstID
 * @property int $advancementSecondID
 * @property int|null $advancementThirdID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereAdvancementFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereAdvancementSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereAdvancementThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementDocument whereUserID($value)
 */
	class AdvancementDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int|null $meerkatID
 * @property int|null $userID
 * @property int $themeID
 * @property int $advancementID
 * @property int|null $advancementSecondID
 * @property int|null $advancementThirdID
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon|null $advancementDate
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAdvancementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAdvancementID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAdvancementSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAdvancementThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereMeerkatID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereThemeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementMeerkat whereUserID($value)
 */
	class AdvancementMeerkat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int|null $type
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $userID
 * @property string $note
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $advancementFirstID
 * @property int $advancementSecondID
 * @property int|null $advancementThirdID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereAdvancementFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereAdvancementSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereAdvancementThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementNote whereUserID($value)
 */
	class AdvancementNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $type
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $userID
 * @property string $description
 * @property string $PDFLocation
 * @property string $thumbLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $advancementFirstID
 * @property int $advancementSecondID
 * @property int|null $advancementThirdID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereAdvancementFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereAdvancementSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereAdvancementThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereThumbLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementPhoto whereUserID($value)
 */
	class AdvancementPhoto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $roverID
 * @property int $userID
 * @property int $themeID
 * @property int $advancementID
 * @property int|null $advancement2ID
 * @property \Illuminate\Support\Carbon $advancementDate
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $latest 1 = Active
 * @property string|null $instructorsName
 * @property int $active 1 = Latest
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereAdvancement2ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereAdvancementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereAdvancementID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereRoverID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereThemeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementRover whereUserID($value)
 */
	class AdvancementRover extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $scoutProgramTypeID
 * @property int $scoutID
 * @property int|null $userID
 * @property int $themeID
 * @property int $advancementID
 * @property int|null $advancement2ID
 * @property \Illuminate\Support\Carbon $advancementDate
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int|null $approvedBy
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereAdvancement2ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereAdvancementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereAdvancementID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereScoutID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereThemeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScout whereUserID($value)
 */
	class AdvancementScout extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $assocToGroup
 * @property int $scouterID
 * @property int $advancementID
 * @property \Illuminate\Support\Carbon $advancementDate
 * @property string|null $notes
 * @property int $latest 1 = latest
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereAdvancementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereAdvancementID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdvancementScouter whereScouterID($value)
 */
	class AdvancementScouter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $userID
 * @property int $fromPosition
 * @property int $ToPosition
 * @property int $fromGroup
 * @property int $toGroup
 * @property int $fromDistrict
 * @property int $toDistrict
 * @property \Illuminate\Support\Carbon $effectiveDate
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereFromDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereFromGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereFromPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereToPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAdultLeaderMove whereUserID($value)
 */
	class AmsAdultLeaderMove extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $userID
 * @property int $awardHeadingID
 * @property int $awardTypeID
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $awardDate
 * @property int|null $awardedBy
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property int|null $declinedBy
 * @property string|null $awardType
 * @property string|null $awardDescription
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAwardDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAwardHeadingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAwardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAwardTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereAwardedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereDeclinedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardApplication whereUserID($value)
 */
	class AmsAwardApplication extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $reason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardHeading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardHeading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardHeading query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardHeading whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardHeading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardHeading whereReason($value)
 */
	class AmsAwardHeading extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property int $awardHeadingID
 * @property int $awardTypeID
 * @property \Illuminate\Support\Carbon $awardDate
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereAwardHeadingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereAwardTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardInfo whereUserID($value)
 */
	class AmsAwardInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $headingID
 * @property int $position
 * @property string $name
 * @property string $shortName
 * @property string $description
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereHeadingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsAwardType whereShortName($value)
 */
	class AmsAwardType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property int $chargeTypeID
 * @property string $chargeNr
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon $issueDate
 * @property \Illuminate\Support\Carbon $expireDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereChargeNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereChargeTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeInfo whereUserID($value)
 */
	class AmsChargeInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property int $forScouts
 * @property string $shortName
 * @property string $description
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereForScouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsChargeType whereShortName($value)
 */
	class AmsChargeType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $userID
 * @property string $criminalType
 * @property string $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereCriminalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsCriminalCheck whereUserID($value)
 */
	class AmsCriminalCheck extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $reason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryHeading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryHeading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryHeading query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryHeading whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryHeading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryHeading whereReason($value)
 */
	class AmsDisciplinaryHeading extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property int $disciplinaryHeadingID
 * @property int $disciplinaryType
 * @property string $sanction
 * @property \Illuminate\Support\Carbon|null $expireDate
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereDisciplinaryHeadingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereDisciplinaryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereSanction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryInfo whereUserID($value)
 */
	class AmsDisciplinaryInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $headingID
 * @property string $offense
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence whereHeadingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDisciplinaryOffence whereOffense($value)
 */
	class AmsDisciplinaryOffence extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $userID
 * @property int $assocToRegion
 * @property int $assocToGroup
 * @property int $assocToDistrict
 * @property int $documentTypeID
 * @property string $description
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereDocumentTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocument whereUserID($value)
 */
	class AmsDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property int|null $aamForm
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType whereAamForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentType whereName($value)
 */
	class AmsDocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentTypesGroup whereName($value)
 */
	class AmsDocumentTypesGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToGroup
 * @property int $assocToDistrict
 * @property int $documentTypeID
 * @property string $description
 * @property string $PDFLocation
 * @property \Illuminate\Support\Carbon $validUntilDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereDocumentTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsDocumentsGroup whereValidUntilDate($value)
 */
	class AmsDocumentsGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsHighestEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsHighestEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsHighestEducation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsHighestEducation whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsHighestEducation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsHighestEducation whereName($value)
 */
	class AmsHighestEducation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $language
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsLanguage whereLanguage($value)
 */
	class AmsLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsMaritalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsMaritalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsMaritalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsMaritalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsMaritalStatus whereName($value)
 */
	class AmsMaritalStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $userID
 * @property int $pastServiceType
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $startDate
 * @property \Illuminate\Support\Carbon $endDate
 * @property string|null $otherRegionName
 * @property string|null $otherDistrictName
 * @property string|null $otherGroupName
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $toBeFixed
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereOtherDistrictName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereOtherGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereOtherRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo wherePastServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereToBeFixed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceInfo whereUserID($value)
 */
	class AmsPastServiceInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property int $newID
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType whereNewID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPastServiceType wherePosition($value)
 */
	class AmsPastServiceType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property string $result
 * @property string|null $documentLocation
 * @property \Illuminate\Support\Carbon $dateDone
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereDateDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereDocumentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsPoliceClearance whereUserID($value)
 */
	class AmsPoliceClearance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property \Illuminate\Support\Carbon $resignDate
 * @property int $resignReasonID
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereResignDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereResignReasonID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignLeader whereUserID($value)
 */
	class AmsResignLeader extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $reason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignReason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignReason whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsResignReason whereReason($value)
 */
	class AmsResignReason extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property \Illuminate\Support\Carbon $retiredDate
 * @property int $retiredReasonID
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereRetiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereRetiredReasonID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireLeader whereUserID($value)
 */
	class AmsRetireLeader extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $reason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireReason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireReason whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsRetireReason whereReason($value)
 */
	class AmsRetireReason extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property \Illuminate\Support\Carbon|null $suspendDate
 * @property int|null $suspenReasonID
 * @property \Illuminate\Support\Carbon|null $unsuspendDate
 * @property int|null $unsuspendedby
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereSuspenReasonID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereSuspendDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereUnsuspendDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereUnsuspendedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendLeader whereUserID($value)
 */
	class AmsSuspendLeader extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $reason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendReason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendReason whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsSuspendReason whereReason($value)
 */
	class AmsSuspendReason extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property \Illuminate\Support\Carbon $terminateDate
 * @property int $terminateReasonID
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereTerminateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereTerminateReasonID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateLeader whereUserID($value)
 */
	class AmsTerminateLeader extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $reason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateReason query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateReason whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTerminateReason whereReason($value)
 */
	class AmsTerminateReason extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $courseType
 * @property int $assocToRegion
 * @property string $name
 * @property string|null $agendaPDFLocation
 * @property string|null $materialPDFLocation
 * @property int $nrOfDays
 * @property int|null $trainingSeats
 * @property int|null $maxBookings
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereAgendaPDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereCourseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereMaterialPDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereMaxBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereNrOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCourse whereTrainingSeats($value)
 */
	class AmsTrainingCourse extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $forAdultLeadersAndRovers
 * @property int $forParents
 * @property int $forScouts
 * @property int $assocToRegion
 * @property string $courseID
 * @property string $courseNumber
 * @property int $directorID
 * @property string $name
 * @property string $description
 * @property int $locationID
 * @property int $courseCost
 * @property \Illuminate\Support\Carbon $bookingCutOffDate
 * @property \Illuminate\Support\Carbon $startDate
 * @property \Illuminate\Support\Carbon $endDate
 * @property string|null $previousQuali
 * @property int|null $maxBookings
 * @property int|null $warrantCourse
 * @property string|null $ical
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereBookingCutOffDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereCourseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereCourseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereDirectorID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereForAdultLeadersAndRovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereForParents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereForScouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereIcal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereLocationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereMaxBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual wherePreviousQuali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnual whereWarrantCourse($value)
 */
	class AmsTrainingCoursesAnnual extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $annualCourseID
 * @property int $dayID
 * @property \Illuminate\Support\Carbon $dayDate
 * @property int $userID
 * @property int $attendance
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereAnnualCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereAttendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereDayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereDayID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualAttendance whereUserID($value)
 */
	class AmsTrainingCoursesAnnualAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $status 1 = Provisional, 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled
 * @property int $assocToRegion
 * @property string $bookingLocation
 * @property int $annualCourseID
 * @property int $userID
 * @property string|null $instructions
 * @property string|null $previousCourses
 * @property string|null $invoiceLocation
 * @property string|null $POPLocation
 * @property int|null $bugMailCount
 * @property int $active
 * @property int $completionConfirmed
 * @property string|null $userPIN
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereAnnualCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereBookingLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereBugMailCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereCompletionConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereInvoiceLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking wherePOPLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking wherePreviousCourses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBooking whereUserPIN($value)
 */
	class AmsTrainingCoursesAnnualBooking extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $bookingID
 * @property int $annualCourseID
 * @property int $userID
 * @property string $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int|null $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereAnnualCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereBookingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsNote whereUserID($value)
 */
	class AmsTrainingCoursesAnnualBookingsNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $bookingID
 * @property int $annualCourseID
 * @property int $userID
 * @property int $fromStatus
 * @property int $toStatus
 * @property \Illuminate\Support\Carbon $created
 * @property int|null $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereAnnualCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereBookingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereFromStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereToStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualBookingsTracking whereUserID($value)
 */
	class AmsTrainingCoursesAnnualBookingsTracking extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $courseID
 * @property int $dayNr
 * @property \Illuminate\Support\Carbon $startDate
 * @property string $startTime
 * @property string $endTime
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereDayNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualDate whereStartTime($value)
 */
	class AmsTrainingCoursesAnnualDate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $annualCourseID
 * @property int $lecturerID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereAnnualCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereLecturerID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualLecturer whereModifiedby($value)
 */
	class AmsTrainingCoursesAnnualLecturer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $annualCourseID
 * @property int $warrantID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereAnnualCourseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesAnnualWarrantsAvailable whereWarrantID($value)
 */
	class AmsTrainingCoursesAnnualWarrantsAvailable extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $colour
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingCoursesType whereName($value)
 */
	class AmsTrainingCoursesType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property string $name
 * @property string $address
 * @property string $gpsLat
 * @property string $gpsLon
 * @property int $trainingSeats
 * @property string $contact
 * @property string|null $tel
 * @property string|null $cell
 * @property string|null $email
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereGpsLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingLocation whereTrainingSeats($value)
 */
	class AmsTrainingLocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property int|null $trainingTypeID
 * @property string|null $courseName
 * @property string $courseNumber
 * @property \Illuminate\Support\Carbon $completionDate
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $validated 1 = Validated
 * @property \Illuminate\Support\Carbon|null $validatedDate
 * @property int|null $validatedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereCompletionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereCourseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereTrainingTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereValidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereValidatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPast whereValidatedby($value)
 */
	class AmsTrainingPast extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int|null $code
 * @property string|null $calendarColour
 * @property string $shortName
 * @property string $description
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereCalendarColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsTrainingPastType whereShortName($value)
 */
	class AmsTrainingPastType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $userID
 * @property int $warrantTypeID
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $awardDate
 * @property int|null $awardedBy
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property int|null $declinedBy
 * @property string|null $awardType
 * @property string|null $awardDescription
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAwardDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAwardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereAwardedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereDeclinedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantApplication whereWarrantTypeID($value)
 */
	class AmsWarrantApplication extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantCancellationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantCancellationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantCancellationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantCancellationType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantCancellationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantCancellationType whereName($value)
 */
	class AmsWarrantCancellationType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int|null $assocToGroup
 * @property int $warrantID
 * @property int $userID
 * @property \Illuminate\Support\Carbon $oldExpireDate
 * @property \Illuminate\Support\Carbon $newExpireDate
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereNewExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereOldExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantExtension whereWarrantID($value)
 */
	class AmsWarrantExtension extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $userID
 * @property int|null $roleID
 * @property int|null $warrantTypeID
 * @property string $warrantNr
 * @property string|null $warrantName
 * @property int $limited
 * @property int $appointment
 * @property string|null $PDFLocation
 * @property \Illuminate\Support\Carbon $issueDate
 * @property \Illuminate\Support\Carbon $expireDate
 * @property int|null $cancellationTypeID
 * @property string|null $cancelationNotes
 * @property int $expireEmailCount
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereAppointment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereCancelationNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereCancellationTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereExpireEmailCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereLimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereWarrantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereWarrantNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantInfo whereWarrantTypeID($value)
 */
	class AmsWarrantInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property string $shortName
 * @property string $description
 * @property int $national
 * @property int $region
 * @property int $district
 * @property int $group
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereNational($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AmsWarrantType whereShortName($value)
 */
	class AmsWarrantType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $key
 * @property int $issuedToUserID
 * @property string $information
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereIssuedToUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiKey whereKey($value)
 */
	class ApiKey extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $IPAddress
 * @property string|null $APICalled
 * @property string|null $userAgent
 * @property string|null $keyUsed
 * @property string|null $presented
 * @property string|null $response
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereAPICalled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereIPAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereKeyUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage wherePresented($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiUsage whereUserAgent($value)
 */
	class ApiUsage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $cubID
 * @property int|null $userID
 * @property int $firstID
 * @property int|null $secondID
 * @property \Illuminate\Support\Carbon $badgeDate
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereBadgeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereCubID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesCub whereUserID($value)
 */
	class BadgesCub extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $type
 * @property int $assocToGroup
 * @property int $userID
 * @property string $description
 * @property string $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $badgeFirstID
 * @property int $badgeSecondID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereBadgeFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereBadgeSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesDocument whereUserID($value)
 */
	class BadgesDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int|null $meerkatID
 * @property int $userID
 * @property int $firstID
 * @property int|null $secondID
 * @property \Illuminate\Support\Carbon $badgeDate
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereBadgeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereMeerkatID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesMeerkat whereUserID($value)
 */
	class BadgesMeerkat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $type
 * @property int $assocToGroup
 * @property int $userID
 * @property string $note
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $firstID
 * @property int $secondID
 * @property int|null $thirdID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesNote whereUserID($value)
 */
	class BadgesNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $type
 * @property int $assocToGroup
 * @property int $userID
 * @property string $description
 * @property string $PDFLocation
 * @property string $thumbLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $badgeFirstID
 * @property int $badgeSecondID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereBadgeFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereBadgeSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereThumbLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesPhoto whereUserID($value)
 */
	class BadgesPhoto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $roverID
 * @property int|null $userID
 * @property int $firstID
 * @property int|null $secondID
 * @property \Illuminate\Support\Carbon $badgeDate
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int|null $approvedBy
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereBadgeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereRoverID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesRover whereUserID($value)
 */
	class BadgesRover extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $scoutID
 * @property int|null $userID
 * @property int $firstID
 * @property int|null $secondID
 * @property \Illuminate\Support\Carbon $badgeDate
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $latest 1 = latest
 * @property string|null $instructorsName
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int|null $approvedBy
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereBadgeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereInstructorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereLatest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereScoutID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BadgesScout whereUserID($value)
 */
	class BadgesScout extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $regionID
 * @property int|null $districtID
 * @property int|null $groupID
 * @property string $XLSLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CensusDocument whereXLSLocation($value)
 */
	class CensusDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array<array-key, mixed> $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model $notifiable
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static \Illuminate\Notifications\DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification read()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomDatabaseNotification whereUpdatedAt($value)
 */
	class CustomDatabaseNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $companyName
 * @property int $countryID
 * @property string $locationName
 * @property string $bio
 * @property string $skills
 * @property int $likes
 * @property string|null $facebook
 * @property string|null $linkedin
 * @property string|null $twitter
 * @property string|null $pintrest
 * @property string|null $googlePlus
 * @property string|null $website
 * @property string $contactPersonName
 * @property string|null $contactEmail
 * @property string|null $contactTel
 * @property int $active
 * @property int $approved
 * @property int|null $approvedBy
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int|null $declined
 * @property int|null $declinedBy
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property string|null $declinedReason
 * @property string|null $declinedNotes
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereContactPersonName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereContactTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereDeclinedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereDeclinedNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereGooglePlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional wherePintrest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessional whereWebsite($value)
 */
	class DirectoryProfessional extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $directoryID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike whereDirectoryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalLike whereId($value)
 */
	class DirectoryProfessionalLike extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $directoryID
 * @property string $review
 * @property int $stars
 * @property int $active
 * @property int $approved
 * @property int|null $approvedBy
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int $declined
 * @property int $declinedReasonID
 * @property int $declinedby
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereDeclinedReasonID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereDeclinedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereDirectoryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectoryProfessionalReview whereStars($value)
 */
	class DirectoryProfessionalReview extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $skill
 * @property int $timesUsed
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill whereSkill($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DirectorySkill whereTimesUsed($value)
 */
	class DirectorySkill extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $regionID
 * @property int $superDistrictID
 * @property string $name
 * @property string|null $description
 * @property string|null $phys_address
 * @property int $countryID
 * @property bool $active
 * @property int $accountID
 * @property bool|null $censusDone
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $churchGroups
 * @property-read int|null $church_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $communityGroups
 * @property-read int|null $community_groups_count
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $dsdGroups
 * @property-read int|null $dsd_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $ngoGroups
 * @property-read int|null $ngo_groups_count
 * @property-read \App\Models\GroupAccount|null $ownedAccount
 * @property-read \App\Models\Region|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $schoolGroups
 * @property-read int|null $school_groups_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereCensusDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District wherePhysAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereSuperDistrictID($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $regionID
 * @property string $name
 * @property string $description
 * @property int $active
 * @property int $accountID
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DistrictsSuper whereRegionID($value)
 */
	class DistrictsSuper extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $page
 * @property string|null $POST
 * @property string|null $errorsFound
 * @property int $userID
 * @property int $roleID
 * @property int $nationalID
 * @property int|null $regionID
 * @property int|null $districtID
 * @property int|null $groupID
 * @property \Illuminate\Support\Carbon|null $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereErrorsFound($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereNationalID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging wherePOST($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorLogging whereUserID($value)
 */
	class ErrorLogging extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string|null $name
 * @property string|null $description
 * @property string|null $gpsLat
 * @property string|null $gpsLon
 * @property int $costPerPerson
 * @property int $depositAmount
 * @property \Illuminate\Support\Carbon|null $depositRequiredDate
 * @property int $MaxBookings
 * @property \Illuminate\Support\Carbon $lastBookingDate
 * @property string $emailAddress
 * @property string $bankName
 * @property string $bankAccountHoldersName
 * @property string $banlBranchName
 * @property string $bankBranchCode
 * @property string $bankAccountNumber
 * @property string $paymentRederence
 * @property \Illuminate\Support\Carbon|null $paymentInFullByDate
 * @property int|null $startAge
 * @property int|null $endAge
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereBankAccountHoldersName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereBankBranchCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereBanlBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereCostPerPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereDepositAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereDepositRequiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereEndAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereGpsLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereLastBookingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereMaxBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange wherePaymentInFullByDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange wherePaymentRederence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventBookingSetupChange whereStartAge($value)
 */
	class EventBookingSetupChange extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $teamID
 * @property int $scoringAreaID
 * @property int $adjudicationScore
 * @property int $active
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereAdjudicationScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereScoringAreaID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionScoreAdjudication whereTeamID($value)
 */
	class EventCompetitionScoreAdjudication extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $questionID
 * @property string $answer
 * @property int $score
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereQuestionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsAnswer whereScore($value)
 */
	class EventCompetitionsAnswer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $teamID
 * @property int $amount
 * @property \Illuminate\Support\Carbon $date
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesInvoice whereTeamID($value)
 */
	class EventCompetitionsFinancesInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $teamID
 * @property int $amount
 * @property \Illuminate\Support\Carbon $date
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsFinancesPayment whereTeamID($value)
 */
	class EventCompetitionsFinancesPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property float $GPSLong
 * @property float $GPSLat
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereGPSLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereGPSLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGp wherePosition($value)
 */
	class EventCompetitionsGp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $groupID
 * @property int $teamNumber
 * @property string $teamName
 * @property int $scoreComplete
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereScoreComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereTeamName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsAttending whereTeamNumber($value)
 */
	class EventCompetitionsGroupsAttending extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $teamID
 * @property int $internalCompetitionID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereInternalCompetitionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsGroupsParticipating whereTeamID($value)
 */
	class EventCompetitionsGroupsParticipating extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsInternalCompetition whereName($value)
 */
	class EventCompetitionsInternalCompetition extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property int $judgeTypeID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereJudgeTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudge whereUserID($value)
 */
	class EventCompetitionsJudge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $canAdmin
 * @property int $canCaptureScores
 * @property int $canAdminJudges
 * @property int $canAdminFinances
 * @property int $canAdminTeams
 * @property int $medical
 * @property int $seaWorthiness
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereCanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereCanAdminFinances($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereCanAdminJudges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereCanAdminTeams($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereCanCaptureScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereMedical($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsJudgesType whereSeaWorthiness($value)
 */
	class EventCompetitionsJudgesType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $eventID
 * @property int|null $groupID
 * @property int|null $districtID
 * @property int|null $regionID
 * @property int|null $roleID
 * @property int $userID
 * @property string|null $userAgent
 * @property float|null $accuracy radius of accuracy meters
 * @property float|null $altitude meters above sea level
 * @property string|null $altitudeAccuracy radius of altitude accuracy meters
 * @property string|null $heading Degrees from true North
 * @property float $latitude
 * @property float $longitude
 * @property float|null $speed meters per second
 * @property int $speedDone
 * @property \Illuminate\Support\Carbon|null $date
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $used
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereAccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereAltitudeAccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereSpeedDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsLocationLogging whereUserID($value)
 */
	class EventCompetitionsLocationLogging extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $internalCompetitionID
 * @property int $scoringAreaID
 * @property int $scoringSheetID
 * @property int $headingID
 * @property string $question
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereHeadingID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereInternalCompetitionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereScoringAreaID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsQuestion whereScoringSheetID($value)
 */
	class EventCompetitionsQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $teamID
 * @property int $scoringAreaID
 * @property int $scoringSheetID
 * @property int $questionID
 * @property int $answerID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property \App\Models\SystemUser|null $modifiedBy
 * @property string|null $notes
 * @property-read \App\Models\SystemUser|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereAnswerID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereQuestionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereScoringAreaID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereScoringSheetID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoring whereTeamID($value)
 */
	class EventCompetitionsScoring extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $internalCompetitionID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereInternalCompetitionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringArea whereName($value)
 */
	class EventCompetitionsScoringArea extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $teamID
 * @property int $scoringSheetID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereScoringSheetID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringDnp whereTeamID($value)
 */
	class EventCompetitionsScoringDnp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $internalCompetitionID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property \Illuminate\Support\Carbon $startDate
 * @property string $startTime
 * @property \Illuminate\Support\Carbon $endDate
 * @property string $endTime
 * @property int $usesGPS
 * @property int $pdf
 * @property int $registration
 * @property int $medicalScore
 * @property int $seaWorthynessScore
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereInternalCompetitionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereMedicalScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet wherePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereSeaWorthynessScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheet whereUsesGPS($value)
 */
	class EventCompetitionsScoringSheet extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $internalCompetitionID
 * @property int $scoringSheetID
 * @property string $heading
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property \App\Models\SystemUser|null $modifiedBy
 * @property-read \App\Models\SystemUser|null $createdBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereInternalCompetitionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereModifiedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsScoringSheetsHeading whereScoringSheetID($value)
 */
	class EventCompetitionsScoringSheetsHeading extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string|null $cookieID
 * @property string|null $userIP
 * @property string|null $teamName
 * @property int|null $initialRegistration
 * @property string|null $improveInitialRegistration
 * @property int|null $communicationPrior
 * @property string|null $improveCommunicationsPrior
 * @property int|null $communicationDuring
 * @property int|null $qualityCommunicationDuring
 * @property int|null $judging
 * @property int|null $judgesEngageWithPL
 * @property string|null $judgingSuggestions
 * @property string|null $improveCommunicationsDuring
 * @property string|null $improveJudging
 * @property string|null $suggestions
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereCommunicationDuring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereCommunicationPrior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereCookieID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereImproveCommunicationsDuring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereImproveCommunicationsPrior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereImproveInitialRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereImproveJudging($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereInitialRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereJudgesEngageWithPL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereJudging($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereJudgingSuggestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereQualityCommunicationDuring($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereSuggestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereTeamName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventCompetitionsSurveyResponse whereUserIP($value)
 */
	class EventCompetitionsSurveyResponse extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $status 1 = Provisional. 2 = Confirmed, 3 = Guaranteed, 4 = Cancelled
 * @property int $userID
 * @property int|null $travelArrangements
 * @property int|null $accommodationArrangements
 * @property int|null $apparelOption
 * @property int|null $patrolID
 * @property int $canAdmin
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereAccommodationArrangements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereApparelOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereCanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking wherePatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereTravelArrangements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBooking whereUserID($value)
 */
	class EventUserBooking extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string $name
 * @property int $cost
 * @property int $nrAvailable
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingAccomodation whereNrAvailable($value)
 */
	class EventUserBookingAccomodation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property int $amount
 * @property string|null $notes
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingCreditNote whereUserID($value)
 */
	class EventUserBookingCreditNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property string $description
 * @property int $amount
 * @property int $transport
 * @property int $accomodation
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereAccomodation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereTransport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingInvoice whereUserID($value)
 */
	class EventUserBookingInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property string $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingNote whereUserID($value)
 */
	class EventUserBookingNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string $name
 * @property int $cost
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingOtherOption whereName($value)
 */
	class EventUserBookingOtherOption extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrol whereName($value)
 */
	class EventUserBookingPatrol extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property int $patrolID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation wherePatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPatrolAllocation whereUserID($value)
 */
	class EventUserBookingPatrolAllocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property int $amount
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPayment whereUserID($value)
 */
	class EventUserBookingPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $userID
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingPop whereUserID($value)
 */
	class EventUserBookingPop extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property int $roleID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingRole whereRoleID($value)
 */
	class EventUserBookingRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string $name
 * @property int $cost
 * @property int $nrAvailable
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUserBookingTransport whereNrAvailable($value)
 */
	class EventUserBookingTransport extends \Eloquent {}
}

namespace App\Models\Forms{
/**
 * @property int $id
 * @property int|null $region_id
 * @property int|null $district_id
 * @property int|null $group_id
 * @property string $status
 * @property string|null $first_name
 * @property string|null $other_names
 * @property string|null $surname
 * @property string|null $nickname
 * @property string $title
 * @property string $sex
 * @property bool $has_south_african_id
 * @property string $id_number
 * @property string $id_document
 * @property string $criminal_record
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $passport_country
 * @property \Illuminate\Support\Carbon|null $passport_date_of_issue
 * @property string $phone_number
 * @property string $email
 * @property string|null $residential_address
 * @property string|null $medical_conditions
 * @property string|null $medical_aid_scheme_name
 * @property string|null $medical_aid_number
 * @property string|null $medical_aid_principal_member
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_phone_number
 * @property bool $has_given_public_media_consent
 * @property string $action_slug
 * @property bool $has_group_been_notified
 * @property bool $has_district_been_notified
 * @property bool $has_regional_been_notified
 * @property bool $has_national_been_notified
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $declined_at
 * @property int|null $declined_by
 * @property string|null $declined_notes_internal
 * @property string|null $declined_reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $actionable_link
 * @property-read \App\Models\SystemUser|null $approvedBy
 * @property-read \App\Models\SystemUser|null $declinedBy
 * @property-read \App\Models\District|null $district
 * @property-read \App\Models\Group|null $group
 * @property-read mixed $name
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereActionSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereCriminalRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereDeclinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereDeclinedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereDeclinedNotesInternal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereEmergencyContactPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereHasDistrictBeenNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereHasGivenPublicMediaConsent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereHasGroupBeenNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereHasNationalBeenNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereHasRegionalBeenNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereHasSouthAfricanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereIdDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereMedicalAidNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereMedicalAidPrincipalMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereMedicalAidSchemeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereMedicalConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereOtherNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest wherePassportCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest wherePassportDateOfIssue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereResidentialAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApplicationAdultMembershipRequest whereUpdatedAt($value)
 */
	class ApplicationAdultMembershipRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property bool $sdLiteOnly
 * @property bool|null $usesGoScan
 * @property bool $usesShop
 * @property bool $usesPayFees
 * @property int $groupAccountID
 * @property string|null $scarf
 * @property int $groupTypeID
 * @property string|null $description
 * @property bool $multiDen
 * @property bool $multiPack
 * @property bool $multiTroop
 * @property bool $multiCrew
 * @property int $meerkatProgramType
 * @property int $cubProgramType
 * @property int $scoutProgramType 1 = Normal Scout Program, 2 = Entsha Scout Program
 * @property int $roverProgramType
 * @property bool $amsOnly 1 = Yes, 0 = No
 * @property bool $hasMeerkats
 * @property bool|null $hasCubs 1 = Yes
 * @property bool|null $hasScouts 1 = Yes
 * @property bool|null $hasRovers 1 = Yes
 * @property bool $hasBranch1
 * @property bool $hasBranch2
 * @property bool $hasBranch3
 * @property bool $hasBranch4
 * @property bool $hasBranch5
 * @property bool $sendWeeklyMails
 * @property int $assoc_to_district
 * @property int $assoc_to_region
 * @property bool|null $roverAssocToGroup
 * @property string|null $phys_address
 * @property string|null $postalAddress
 * @property int|null $postalCountryID
 * @property int|null $phys_country_id
 * @property string|null $bankingDetails
 * @property string|null $bankAccountName
 * @property string|null $bankName
 * @property string|null $branchName
 * @property string|null $branchCode
 * @property string|null $bankAccountNumber
 * @property string|null $invoiceNotes
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $website
 * @property string|null $email
 * @property string|null $googleplus
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $pintrest
 * @property string|null $youtube
 * @property string|null $tumblr
 * @property string|null $googleMaps
 * @property string|null $gpsLat
 * @property string|null $gpsLon
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property bool $active 1 = Active
 * @property string|null $weatherID
 * @property string|null $weatherLocationName
 * @property bool $managedRegionally 1 = Yrs, 0 = No
 * @property bool $canMoveToEntsha
 * @property bool $using20
 * @property string|null $groupRegNr
 * @property bool|null $censusDone
 * @property \Illuminate\Support\Carbon|null $groupLastUpdated
 * @property int|null $groupLastUpdatedBy
 * @property-read mixed $bank_info_short
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read mixed $cub_program_type_label
 * @property-read \App\Models\District|null $district
 * @property-read mixed $group_type_label
 * @property-read mixed $meerkat_program_type_label
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupsMulti> $multiSections
 * @property-read int|null $multi_sections_count
 * @property-read \App\Models\Region|null $region
 * @property-read mixed $rover_program_type_label
 * @property-read mixed $scout_program_type_label
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group notScoutingInSchools()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereAmsOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereBankAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereBankingDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereBranchCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCanMoveToEntsha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCensusDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCubProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGoogleMaps($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGoogleplus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGpsLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupLastUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupLastUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupRegNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasBranch1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasBranch2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasBranch3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasBranch4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasBranch5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasCubs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasMeerkats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasRovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereHasScouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereInvoiceNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereManagedRegionally($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMeerkatProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMultiCrew($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMultiDen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMultiPack($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMultiTroop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePhysAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePhysCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePintrest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePostalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePostalCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereRoverAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereRoverProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereScarf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereScoutProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereSdLiteOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereSendWeeklyMails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereTumblr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUsesGoScan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUsesPayFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUsesShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUsing20($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereWeatherID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereWeatherLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereYoutube($value)
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $accountName
 * @property int $accountType
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $nationalAccount
 * @property int $regionalAccount
 * @property int $districtAccount
 * @property int $groupAccount
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereDistrictAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereGroupAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereNationalAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccount whereRegionalAccount($value)
 */
	class GroupAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $transferID
 * @property string $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountTransfersNote whereTransferID($value)
 */
	class GroupAccountTransfersNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $fromCountryID
 * @property int $fromRegionID
 * @property int $fromDistrictID
 * @property int $fromGroupID
 * @property int $toCountryID
 * @property int $toRegionID
 * @property int $toDistrictID
 * @property int $toGroupID
 * @property int $accountID
 * @property int $action 1 = From SGL Must Approve, 2 = From Treasurer Must Approve, 3 = To SGL Must Approve
 * @property string $notes
 * @property int|null $fromSGLApproved
 * @property int|null $fromSGLID
 * @property \Illuminate\Support\Carbon|null $fromSGLApprovedDate
 * @property string|null $fromSGLNotes
 * @property int|null $fromTreasurerApproved
 * @property int|null $fromTreasurerID
 * @property \Illuminate\Support\Carbon|null $fromTreasurerApprovedDate
 * @property string|null $fromTreasurerNotes
 * @property int|null $toSGLApproved
 * @property int|null $toSGLID
 * @property \Illuminate\Support\Carbon|null $toSGLApprovedDate
 * @property string|null $toSGLNotes
 * @property \Illuminate\Support\Carbon|null $actualTransferDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereActualTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromSGLApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromSGLApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromSGLID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromSGLNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromTreasurerApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromTreasurerApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromTreasurerID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereFromTreasurerNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToSGLApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToSGLApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToSGLID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfer whereToSGLNotes($value)
 */
	class GroupAccountsTransfer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfersStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfersStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfersStage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfersStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAccountsTransfersStage whereName($value)
 */
	class GroupAccountsTransfersStage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $scoutProgramTypeID
 * @property string $type Cub Or Scout
 * @property int $eventID
 * @property int $firstID
 * @property int $secondID
 * @property int|null $thirdID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInEvent whereType($value)
 */
	class GroupAdvancementsInEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $scoutProgramTypeID
 * @property string $type Cub Or Scout
 * @property int $programID
 * @property int $firstID
 * @property int $secondID
 * @property int $thirdID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAdvancementsInProgram whereType($value)
 */
	class GroupAdvancementsInProgram extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userId
 * @property string|null $userSex
 * @property string $type
 * @property int|null $programId
 * @property int|null $eventId
 * @property \Illuminate\Support\Carbon $programDate
 * @property int $assocToGroup
 * @property int $attendance 1 = Attended
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int $moved
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereAttendance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereMoved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereProgramDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupAttendance whereUserSex($value)
 */
	class GroupAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $scoutProgramTypeID
 * @property string $type Cub Or Scout
 * @property int $eventID
 * @property int $firstID
 * @property int $secondID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInEvent whereType($value)
 */
	class GroupBadgesInEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $scoutProgramTypeID
 * @property string $type Cub Or Scout
 * @property int $programID
 * @property int $firstID
 * @property int $secondID
 * @property int $thirdID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereThirdID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupBadgesInProgram whereType($value)
 */
	class GroupBadgesInProgram extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $userID
 * @property int $typeID
 * @property \Illuminate\Support\Carbon $dateAppointed
 * @property \Illuminate\Support\Carbon|null $dateRemoved
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereDateAppointed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereDateRemoved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCommittee whereUserID($value)
 */
	class GroupCommittee extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $userID
 * @property int $typeID
 * @property \Illuminate\Support\Carbon $dateAppointed
 * @property \Illuminate\Support\Carbon|null $dateRemoved
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereDateAppointed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereDateRemoved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCouncil whereUserID($value)
 */
	class GroupCouncil extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $assocToGroup
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubPack whereName($value)
 */
	class GroupCubPack extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int|null $packID
 * @property string $name
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupCubsSixesName wherePackID($value)
 */
	class GroupCubsSixesName extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $reportMonth
 * @property string $area
 * @property int $boys
 * @property int $girls
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReport whereReportMonth($value)
 */
	class GroupDistrictReport extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $reportMonth
 * @property \Illuminate\Support\Carbon $LastMonth
 * @property int $lastMonthBoys
 * @property int $lastMonthGirls
 * @property int $thisMonthBoys
 * @property int $thisMonthGirls
 * @property int $jtpBoys
 * @property int $jtpGirls
 * @property int $ltpBoys
 * @property int $ltpGirls
 * @property int $leavingBoys
 * @property int $leavingGirls
 * @property int $toScoutsBoys
 * @property int $toScoutsGirls
 * @property int $usMale
 * @property int $usFemale
 * @property int $parentHelperMale
 * @property int $parentHelperFemale
 * @property int $committeeMale
 * @property int $committeeFemale
 * @property int $membershipBoys
 * @property int $membershipGirls
 * @property int $swBoys
 * @property int $swGirls
 * @property int $gwBoys
 * @property int $gwGirls
 * @property int $lwBoys
 * @property int $lwGirls
 * @property int $badgesBoys
 * @property int $badgesGirls
 * @property int $advBoys
 * @property int $advGirls
 * @property string $advancement
 * @property string $packActivity
 * @property string $groupActivity
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereAdvBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereAdvGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereAdvancement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereBadgesBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereBadgesGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereCommitteeFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereCommitteeMale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereGroupActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereGwBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereGwGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereJtpBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereJtpGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLastMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLastMonthBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLastMonthGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLeavingBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLeavingGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLtpBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLtpGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLwBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereLwGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereMembershipBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereMembershipGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub wherePackActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereParentHelperFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereParentHelperMale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereReportMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereSwBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereSwGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereThisMonthBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereThisMonthGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereToScoutsBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereToScoutsGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereUsFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCub whereUsMale($value)
 */
	class GroupDistrictReportsCub extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property string $reportMonth
 * @property int $nr
 * @property \Illuminate\Support\Carbon $date
 * @property int $strength
 * @property int $present
 * @property int $percent
 * @property string $comments
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance wherePresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereReportMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsCubsAttendance whereStrength($value)
 */
	class GroupDistrictReportsCubsAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $reportMonth
 * @property \Illuminate\Support\Carbon $LastMonth
 * @property int $lastMonthBoys
 * @property int $lastMonthGirls
 * @property int $thisMonthBoys
 * @property int $thisMonthGirls
 * @property int $jttBoys
 * @property int $jttGirls
 * @property int $lttBoys
 * @property int $lttGirls
 * @property int $leavingBoys
 * @property int $leavingGirls
 * @property int $toRoversBoys
 * @property int $toRoversGirls
 * @property int $usMale
 * @property int $usFemale
 * @property int $parentHelperMale
 * @property int $parentHelperFemale
 * @property int $committeeMale
 * @property int $committeeFemale
 * @property int $membershipBoys
 * @property int $membershipGirls
 * @property int $pfBoys
 * @property int $pfGirls
 * @property int $adBoys
 * @property int $adGirls
 * @property int $fcBoys
 * @property int $fcGirls
 * @property int $exBoys
 * @property int $exGirls
 * @property int $spBoys
 * @property int $spGirls
 * @property int $badgesBoys
 * @property int $badgesGirls
 * @property int $advBoys
 * @property int $advGirls
 * @property string $advancement
 * @property string $troopActivity
 * @property string $groupActivity
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAdBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAdGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAdvBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAdvGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAdvancement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereBadgesBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereBadgesGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereCommitteeFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereCommitteeMale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereExBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereExGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereFcBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereFcGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereGroupActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereJttBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereJttGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLastMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLastMonthBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLastMonthGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLeavingBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLeavingGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLttBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereLttGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereMembershipBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereMembershipGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereParentHelperFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereParentHelperMale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout wherePfBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout wherePfGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereReportMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereSpBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereSpGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereThisMonthBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereThisMonthGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereToRoversBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereToRoversGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereTroopActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereUsFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScout whereUsMale($value)
 */
	class GroupDistrictReportsScout extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $assocToGroup
 * @property string $reportMonth
 * @property int $nr
 * @property \Illuminate\Support\Carbon $date
 * @property int $strength
 * @property int $present
 * @property int $percent
 * @property string $comments
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance wherePresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereReportMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDistrictReportsScoutsAttendance whereStrength($value)
 */
	class GroupDistrictReportsScoutsAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $docType
 * @property string|null $docArea
 * @property int|null $assocToPerson
 * @property int $assocToAccount
 * @property int $assocToGroup
 * @property string $description
 * @property string $location
 * @property \Illuminate\Support\Carbon|null $expiryDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereAssocToAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereAssocToPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereDocArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereDocType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupDocument whereModifiedby($value)
 */
	class GroupDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $groupID
 * @property string|null $fromData
 * @property string|null $toData
 * @property \Illuminate\Support\Carbon|null $created
 * @property int|null $createdByID
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord whereCreatedByID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord whereFromData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEditRecord whereToData($value)
 */
	class GroupEditRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property string $name
 * @property string $description
 * @property int $locationID
 * @property int $purchased 2 = Purchased, 1 = Donated
 * @property int|null $purchaseCost
 * @property int|null $replacementCost
 * @property int $totalPurchaseCost
 * @property int $totalReplacementCost
 * @property \Illuminate\Support\Carbon $purchaseDate
 * @property string|null $purchaseLocation
 * @property int $qty
 * @property int $insured 1 = Insured
 * @property string $expectedLifeFromPurchaseDate
 * @property string $assetCondition
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereAssetCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereExpectedLifeFromPurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereInsured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereLocationID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment wherePurchaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment wherePurchaseLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment wherePurchased($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereReplacementCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereTotalPurchaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipment whereTotalReplacementCost($value)
 */
	class GroupEquipment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property string $name
 * @property string|null $description
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEquipmentStore whereName($value)
 */
	class GroupEquipmentStore extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $nationalEvent
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $assocToDistrict
 * @property int $assocToRegion
 * @property int $associatedToNationalEventID
 * @property int $associatedToRegionEventID
 * @property int $associatedToDistrictEventID
 * @property int $eventFor 1 = Cubs Only, 2 = Scouts Only, 3 = Rovers Only, 4 = Adults Only, 5 = Group, 6 = Meerkats Only
 * @property int $eventFor2 1 = Groups, 2 = Adult Leaders
 * @property int $eventAway 1 = Away, 2 = At Scout Hall
 * @property int $eventPatrolID
 * @property int|null $multiID
 * @property int|null $denID
 * @property int|null $packID
 * @property int|null $troopID
 * @property int|null $crewID
 * @property string $name
 * @property string $description
 * @property int $heldInDistrict
 * @property string|null $uploadedDoc Location Of The Uploaded Doc
 * @property string $locationName
 * @property string $locationAddress
 * @property string|null $locationLat
 * @property string|null $locationLon
 * @property \Illuminate\Support\Carbon $startDate
 * @property string $startTime
 * @property \Illuminate\Support\Carbon $endDate
 * @property string $endTime
 * @property int $scouterResponsible
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property float|null $costPerPerson
 * @property string|null $costPerPersonPer
 * @property int|null $nightUnderCanvas
 * @property float|null $kmHike
 * @property int $eventTypeID
 * @property string|null $permitDocLocation
 * @property string $uniqueID
 * @property int $eventPSPin
 * @property int $eventTSPin
 * @property int $eventSGLPin
 * @property int $eventDCPin
 * @property int $eventOtherDCPin
 * @property int $active
 * @property int $approved
 * @property string|null $planningDoc
 * @property string|null $marketingDoc
 * @property int $competition
 * @property float $competitionScoringFactor
 * @property int|null $competitionScoringDefaultPage
 * @property int|null $competitionScorePrecheck
 * @property int $addedIn
 * @property int $bookingPossible
 * @property \Illuminate\Support\Carbon|null $latestBookingDate
 * @property int $maxNrOfBookings
 * @property string|null $managementEmail
 * @property int $depositRequired
 * @property \Illuminate\Support\Carbon|null $depositRequiredDate
 * @property \Illuminate\Support\Carbon|null $paymentInFullByDate
 * @property string|null $travelArrangements
 * @property int $bookingLive
 * @property string|null $bankName
 * @property string|null $bankAccountName
 * @property string|null $bankBranch
 * @property string|null $bankCode
 * @property string|null $bankAccountNumber
 * @property string|null $BAReferenceStart
 * @property int|null $startAge
 * @property int|null $endAge
 * @property int $GPSTrackingRequired
 * @property int $noCopy
 * @property string|null $surveyURL
 * @property string|null $leaderboardURL
 * @property string|null $calendarURL
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAddedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAssociatedToDistrictEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAssociatedToNationalEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereAssociatedToRegionEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBAReferenceStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBankAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBankBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBookingLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereBookingPossible($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCalendarURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCompetition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCompetitionScorePrecheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCompetitionScoringDefaultPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCompetitionScoringFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCostPerPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCostPerPersonPer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereCrewID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereDenID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereDepositRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereDepositRequiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEndAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventAway($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventDCPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventFor2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventOtherDCPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventPSPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventPatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventSGLPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventTSPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereEventTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereGPSTrackingRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereHeldInDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereKmHike($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLatestBookingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLeaderboardURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLocationAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLocationLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLocationLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereManagementEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereMarketingDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereMaxNrOfBookings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereMultiID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereNationalEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereNightUnderCanvas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereNoCopy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent wherePackID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent wherePaymentInFullByDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent wherePermitDocLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent wherePlanningDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereScouterResponsible($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereStartAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereSurveyURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereTravelArrangements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereTroopID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereUniqueID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEvent whereUploadedDoc($value)
 */
	class GroupEvent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $eventID
 * @property string $name
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventDocument wherePDFLocation($value)
 */
	class GroupEventDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $groupID
 * @property int $eventID
 * @property int $userID
 * @property int $roleID
 * @property int $attending 0 = Not Attending, 1 = Attending, 2 = Maybe Attending
 * @property float|null $cost
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereAttending($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereEventID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupEventsAttending whereUserID($value)
 */
	class GroupEventsAttending extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $accountID
 * @property string $description
 * @property float $amount
 * @property int $amountIncludesVAT 1 = Yes
 * @property int $financialYear
 * @property int $active 1 = active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereAmountIncludesVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereFinancialYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialAnnualInvoiceDiscount whereModifiedby($value)
 */
	class GroupFinancialAnnualInvoiceDiscount extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $invoiceID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $accountID
 * @property int $financialYearID
 * @property string|null $PDFLocation
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereFinancialYearID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNote wherePDFLocation($value)
 */
	class GroupFinancialCreditNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $invoiceID
 * @property int $creditNoteID
 * @property int $assocToGroup
 * @property int $accountID
 * @property int $financialYearID
 * @property string|null $feeArea
 * @property string|null $name
 * @property string $description
 * @property float $amount
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereCreditNoteID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereFeeArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereFinancialYearID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialCreditNotesItem whereName($value)
 */
	class GroupFinancialCreditNotesItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $financialYearID
 * @property int $feeTypeID
 * @property float $feeAmount
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereFeeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereFeeTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereFinancialYearID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFee whereModifiedby($value)
 */
	class GroupFinancialFee extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property string $name
 * @property string|null $description
 * @property int $canBeProrated 1 = Yes
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereCanBeProrated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialFeeType whereName($value)
 */
	class GroupFinancialFeeType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $accountID
 * @property int $financialYearID
 * @property \Illuminate\Support\Carbon $dueDate
 * @property int $annualInvoice
 * @property string|null $PDFLocation
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereAnnualInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereFinancialYearID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoice wherePDFLocation($value)
 */
	class GroupFinancialInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $accountID
 * @property int $financialYearID
 * @property int $invoiceID
 * @property \Illuminate\Support\Carbon $sentDate
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereFinancialYearID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesEmailed whereSentDate($value)
 */
	class GroupFinancialInvoicesEmailed extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $invoiceID
 * @property int $assocToGroup
 * @property int $accountID
 * @property int $financialYearID
 * @property string $feeArea
 * @property string $name
 * @property string $description
 * @property float $amount
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereFeeArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereFinancialYearID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialInvoicesItem whereName($value)
 */
	class GroupFinancialInvoicesItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $invoiceID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $accountID
 * @property float $amount
 * @property \Illuminate\Support\Carbon $payment_date
 * @property int $paymentType 1 = Group Captured, 2 = From Wallet
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialPaymentsMade wherePaymentType($value)
 */
	class GroupFinancialPaymentsMade extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $startDate
 * @property \Illuminate\Support\Carbon $endDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupFinancialYear whereStartDate($value)
 */
	class GroupFinancialYear extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $assocToGroup
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatDen whereName($value)
 */
	class GroupMeerkatDen extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $packID
 * @property string $name
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMeerkatsPatrolName wherePackID($value)
 */
	class GroupMeerkatsPatrolName extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $newsletterDate
 * @property string $newsletterTitle
 * @property string $uploadedFile
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereNewsletterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereNewsletterTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupNewsletter whereUploadedFile($value)
 */
	class GroupNewsletter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $newsletterDate
 * @property string $newsletterTitle
 * @property string $uploadedFile
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereNewsletterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereNewsletterTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupParentsCommitteeMinute whereUploadedFile($value)
 */
	class GroupParentsCommitteeMinute extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property string|null $programAreaName
 * @property int $multiID
 * @property int $denID
 * @property int|null $packID
 * @property int|null $troopID
 * @property int $crewID
 * @property int $programType
 * @property int $meerkatProgramTypeID
 * @property int $cubProgramTypeID
 * @property int $scoutProgramTypeID
 * @property int|null $roverProgramTypeID
 * @property int|null $responsibleScouter
 * @property int|null $dutyPatrol
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property string|null $document
 * @property int $active 1 = active
 * @property int $shared
 * @property int|null $sharedby
 * @property \Illuminate\Support\Carbon|null $sharedDate
 * @property int|null $roverProgramType
 * @property int $online
 * @property int $onlineActive
 * @property \Illuminate\Support\Carbon|null $onlineEndDate
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereCrewID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereCubProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereDenID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereDutyPatrol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereMeerkatProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereMultiID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereOnlineActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereOnlineEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram wherePackID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereProgramAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereResponsibleScouter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereRoverProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereRoverProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereShared($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereSharedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereSharedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgram whereTroopID($value)
 */
	class GroupProgram extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property string $name
 * @property string $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsDocument whereProgramID($value)
 */
	class GroupProgramsDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $position
 * @property string $task
 * @property string|null $needs
 * @property string $description
 * @property string|null $PDFLocation
 * @property int|null $advancementID
 * @property int|null $badgeID
 * @property int|null $points
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereAdvancementID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereBadgeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereNeeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTask whereTask($value)
 */
	class GroupProgramsOnlineTask extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $taskID
 * @property int $userID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereTaskID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksCompletion whereUserID($value)
 */
	class GroupProgramsOnlineTasksCompletion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $taskID
 * @property int $userID
 * @property string|null $description
 * @property string $location
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereTaskID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksDocument whereUserID($value)
 */
	class GroupProgramsOnlineTasksDocument extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $taskID
 * @property int $userID
 * @property string|null $description
 * @property string $location
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereTaskID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksImage whereUserID($value)
 */
	class GroupProgramsOnlineTasksImage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $taskID
 * @property int $userID
 * @property string $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereTaskID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksNote whereUserID($value)
 */
	class GroupProgramsOnlineTasksNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $taskID
 * @property int $userID
 * @property int $penalty
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty wherePenalty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereTaskID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineTasksPenalty whereUserID($value)
 */
	class GroupProgramsOnlineTasksPenalty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programID
 * @property int $userID
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupProgramsOnlineWorkingOn whereUserID($value)
 */
	class GroupProgramsOnlineWorkingOn extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoverCrew whereName($value)
 */
	class GroupRoverCrew extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $crewID
 * @property string $name
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereCrewID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupRoversPatrolName whereName($value)
 */
	class GroupRoversPatrolName extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutTroop whereName($value)
 */
	class GroupScoutTroop extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $scoutID
 * @property int $chargeID
 * @property string $chargeNr
 * @property \Illuminate\Support\Carbon $awardDate
 * @property \Illuminate\Support\Carbon $expireDate
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereChargeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereChargeNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsCharge whereScoutID($value)
 */
	class GroupScoutsCharge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int|null $assocToRegion
 * @property int|null $assocToDistrict
 * @property int $assocToGroup
 * @property int $troopID
 * @property string $name
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupScoutsPatrolName whereTroopID($value)
 */
	class GroupScoutsPatrolName extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupSendLogonDetail whereUserID($value)
 */
	class GroupSendLogonDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $year
 * @property int $area
 * @property int $multiID
 * @property int $awardID
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereAwardID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereMultiID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupStarAward whereYear($value)
 */
	class GroupStarAward extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property string $pictureLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange wherePictureLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupUserPictureChange whereUserID($value)
 */
	class GroupUserPictureChange extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToGroup
 * @property int $accountID
 * @property int $userID
 * @property int $programID
 * @property \Illuminate\Support\Carbon $programDate
 * @property \Illuminate\Support\Carbon $sentDate
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property string $mailType
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereMailType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereProgramDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereProgramID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereSentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupWeeklyEmailsEmailed whereUserID($value)
 */
	class GroupWeeklyEmailsEmailed extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property int $userID
 * @property int $chargeTypeID
 * @property string $chargeNr
 * @property \Illuminate\Support\Carbon $awardDate
 * @property \Illuminate\Support\Carbon $expireDate
 * @property string|null $PDFLocation
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereChargeNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereChargeTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupYouthCharge whereUserID($value)
 */
	class GroupYouthCharge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsEntshaMove whereRegionID($value)
 */
	class GroupsEntshaMove extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property int $groupID
 * @property string $name
 * @property bool $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property string|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\Region|null $district
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsMulti whereType($value)
 */
	class GroupsMulti extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $groupID
 * @property int $districtID
 * @property int $regionID
 * @property int $countryID
 * @property int|null $ownedRented 1 = Owned, 2 = Rented
 * @property string|null $landlordName
 * @property string|null $landlordContactPerson
 * @property string|null $landlordContactPersonCell
 * @property string|null $landlordContactPersonEmail
 * @property string|null $propertyDescription
 * @property string|null $ERFno
 * @property string|null $ERFSize
 * @property int|null $propertyValuation
 * @property \Illuminate\Support\Carbon|null $lastValuationDate
 * @property int|null $improvementValue
 * @property \Illuminate\Support\Carbon|null $leaseStartDate
 * @property \Illuminate\Support\Carbon|null $leaseEndDate
 * @property \Illuminate\Support\Carbon|null $leaseRenewalDate
 * @property string|null $leaseConditions
 * @property string|null $improvementsDescription
 * @property int|null $monthlyRentalAmount
 * @property int|null $monthlyRates
 * @property int|null $monthlyElectricity
 * @property int|null $monthlyWaterSewerage
 * @property string|null $insuranceCompany
 * @property string|null $insuranceContactPerson
 * @property string|null $insuranceContactPersonEmail
 * @property string|null $insuranceContactPersonCell
 * @property int|null $insuranceValue
 * @property string|null $insuranceDetails
 * @property string|null $groupNotes
 * @property \Illuminate\Support\Carbon|null $created
 * @property int|null $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereERFSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereERFno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereGroupNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereImprovementValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereImprovementsDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereInsuranceCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereInsuranceContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereInsuranceContactPersonCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereInsuranceContactPersonEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereInsuranceDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereInsuranceValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLandlordContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLandlordContactPersonCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLandlordContactPersonEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLandlordName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLastValuationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLeaseConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLeaseEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLeaseRenewalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereLeaseStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereMonthlyElectricity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereMonthlyRates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereMonthlyRentalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereMonthlyWaterSewerage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereOwnedRented($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty wherePropertyDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty wherePropertyValuation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsProperty whereRegionID($value)
 */
	class GroupsProperty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $owned
 * @property int $rented
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType whereOwned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyOwnershipType whereRented($value)
 */
	class GroupsPropertyOwnershipType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $groupID
 * @property int $updatedby
 * @property \Illuminate\Support\Carbon $updatedDate
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate whereUpdatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsPropertyUpdate whereUpdatedby($value)
 */
	class GroupsPropertyUpdate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupsType whereName($value)
 */
	class GroupsType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $region
 * @property int $type 1 = Hiking, 2 = Camping, 3 = Supplier
 * @property string $name
 * @property string $description
 * @property string $contactPerson
 * @property string|null $email
 * @property string|null $tel
 * @property string|null $website
 * @property string $address
 * @property string|null $gpsLat
 * @property string|null $gpsLon
 * @property int $active
 * @property int $approved
 * @property int|null $approvedby
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int $declined
 * @property int|null $declinedby
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property string|null $declinedReason
 * @property string|null $declinedNotes
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereApprovedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereDeclinedNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereDeclinedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereGpsLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharing whereWebsite($value)
 */
	class InfoSharing extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $infoID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingLike whereInfoID($value)
 */
	class InfoSharingLike extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $infoID
 * @property string $title
 * @property string $review
 * @property int|null $stars
 * @property int $active
 * @property int $approved
 * @property int $declined
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property int|null $approvedby
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property int|null $declinedby
 * @property string|null $declineReason
 * @property string|null $declinedNotes
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereApprovedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereDeclineReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereDeclinedNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereDeclinedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereInfoID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingReview whereTitle($value)
 */
	class InfoSharingReview extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InfoSharingType whereName($value)
 */
	class InfoSharingType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenter whereName($value)
 */
	class JamboreeActivityCenter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $centerID
 * @property string $name
 * @property int $active
 * @property int $concurrentPatrols
 * @property float $hoursLong
 * @property int $slots
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereCenterID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereConcurrentPatrols($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereHoursLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeActivityCenterBase whereSlots($value)
 */
	class JamboreeActivityCenterBase extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $subCampID
 * @property int $activityCenterID
 * @property int $baseID
 * @property int $roleID
 * @property int $userID
 * @property string|null $notes
 * @property int $active
 * @property int|null $position
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereActivityCenterID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereBaseID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereSubCampID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultAllocation whereUserID($value)
 */
	class JamboreeAdultAllocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property string $name
 * @property int $active
 * @property int $position
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeAdultRole wherePosition($value)
 */
	class JamboreeAdultRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $active
 * @property int $jamboreeID
 * @property string|null $jamboreeNumber
 * @property int $stepComplete
 * @property \Illuminate\Support\Carbon|null $step1Complete
 * @property \Illuminate\Support\Carbon|null $step2Complete
 * @property \Illuminate\Support\Carbon|null $step3Complete
 * @property \Illuminate\Support\Carbon|null $step4Complete
 * @property \Illuminate\Support\Carbon|null $step5Complete
 * @property \Illuminate\Support\Carbon|null $step6Complete
 * @property \Illuminate\Support\Carbon|null $step7Complete
 * @property \Illuminate\Support\Carbon|null $step8Complete
 * @property string|null $step1notes
 * @property string|null $step2notes
 * @property string|null $step3notes
 * @property string|null $step4notes
 * @property string|null $step5notes
 * @property string|null $step6notes
 * @property string|null $step7notes
 * @property string|null $step8notes
 * @property string|null $currentGrade
 * @property string|null $advancementLevel
 * @property string|null $pltuAttendedYear
 * @property string|null $trainingAttended
 * @property string|null $previousNational
 * @property string|null $jamboreeAttended
 * @property string|null $jamboreeYear
 * @property string|null $capSize
 * @property string|null $tShirtSize
 * @property string|null $golfShirtSize
 * @property int|null $busRegionID
 * @property int $TravelingWithChildren
 * @property int $completed
 * @property int|null $gpsCheckDone
 * @property string|null $ConsentLocation
 * @property string|null $busInvoiceLocation
 * @property int|null $applicationApproved
 * @property \Illuminate\Support\Carbon|null $applicationApprovedDate
 * @property int|null $applicationApprovedBy
 * @property int|null $declinedPosition
 * @property \Illuminate\Support\Carbon|null $declinedPositionDate
 * @property int|null $declinedPositionBy
 * @property string|null $declinedReason
 * @property int|null $passportGenerated
 * @property \Illuminate\Support\Carbon $startDate
 * @property \Illuminate\Support\Carbon $endDate
 * @property int $nrOfDays
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereAdvancementLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereApplicationApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereApplicationApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereApplicationApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereBusInvoiceLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereBusRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereCapSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereConsentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereCurrentGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereDeclinedPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereDeclinedPositionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereDeclinedPositionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereGolfShirtSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereGpsCheckDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereJamboreeAttended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereJamboreeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereJamboreeYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereNrOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication wherePassportGenerated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication wherePltuAttendedYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication wherePreviousNational($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep1Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep1notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep2Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep2notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep3Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep3notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep4Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep4notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep5Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep5notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep6Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep6notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep7Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep7notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep8Complete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStep8notes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereStepComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereTShirtSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereTrainingAttended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereTravelingWithChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeApplication whereUserID($value)
 */
	class JamboreeApplication extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $subcampID
 * @property int $type 1 = Adults, 2 = Kids
 * @property string $name
 * @property int $nrBeds
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed whereNrBeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed whereSubcampID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBed whereType($value)
 */
	class JamboreeBed extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $subcampID
 * @property int $troopID
 * @property int $patrolID
 * @property int $bedID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation whereBedID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation wherePatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation whereSubcampID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBedsAllocation whereTroopID($value)
 */
	class JamboreeBedsAllocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $regionID
 * @property string $provider
 * @property float|null $totalBusCost
 * @property float|null $perSeatInvoiceAmountExVAT
 * @property string|null $busNr
 * @property int $availableSeats
 * @property string $departureLocation
 * @property \Illuminate\Support\Carbon $departureDate
 * @property string $departureTime
 * @property string|null $arrivalLocation
 * @property \Illuminate\Support\Carbon|null $arrivalDate
 * @property string|null $arrivalTime
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereArrivalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereArrivalLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereAvailableSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereBusNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereDepartureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereDepartureLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereDepartureTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo wherePerSeatInvoiceAmountExVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusInfo whereTotalBusCost($value)
 */
	class JamboreeBusInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $userID
 * @property int $busID
 * @property string|null $notes
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereBusID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeBusesUser whereUserID($value)
 */
	class JamboreeBusesUser extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $userID
 * @property int $canAdmin
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereCanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeCoreTeam whereUserID($value)
 */
	class JamboreeCoreTeam extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $userID
 * @property int $roleID
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeEoi whereUserID($value)
 */
	class JamboreeEoi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $userID
 * @property int|null $parentID
 * @property int $positionID
 * @property int|null $passportCountryID
 * @property int|null $passportCheck
 * @property string $notes
 * @property \Illuminate\Support\Carbon $created
 * @property int $active
 * @property int|null $offeredPosition
 * @property \Illuminate\Support\Carbon|null $offeredPositionDate
 * @property int|null $offeredPositionBy
 * @property int|null $declinedPosition
 * @property \Illuminate\Support\Carbon|null $declinedPositionDate
 * @property int|null $declinedPositionBy
 * @property string|null $declinedReason
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereDeclinedPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereDeclinedPositionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereDeclinedPositionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereOfferedPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereOfferedPositionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereOfferedPositionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereParentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest wherePassportCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest wherePassportCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest wherePositionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeExprOfInterest whereUserID($value)
 */
	class JamboreeExprOfInterest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $subCampID
 * @property int $troopID
 * @property int $busID
 * @property int $userID
 * @property string $type
 * @property string $PDFLocation
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereBusID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereSubCampID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereTroopID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeGeneratedPdf whereUserID($value)
 */
	class JamboreeGeneratedPdf extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $year
 * @property string $currency
 * @property float $scoutCostExVAT
 * @property float $adultCostExVAT
 * @property float $kidCostExVAT
 * @property float $busDepositExVAT
 * @property int $depositPercent
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereAdultCostExVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereBusDepositExVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereDepositPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereKidCostExVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereScoutCostExVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInfo whereYear($value)
 */
	class JamboreeInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $userID
 * @property string $thought
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereThought($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInitialThought whereUserID($value)
 */
	class JamboreeInitialThought extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $userID
 * @property float|null $invoiceAmountExVat
 * @property float|null $invoiceVATAmount
 * @property float|null $invoiceTotalAmount
 * @property \Illuminate\Support\Carbon $dueDate
 * @property string|null $PDFLocation
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereInvoiceAmountExVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereInvoiceTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereInvoiceVATAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoice whereUserID($value)
 */
	class JamboreeInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $invoiceID
 * @property int $applicantID
 * @property string $description
 * @property int $number
 * @property float $unitAmount
 * @property float $totalAmount
 * @property int $active 1 = Active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereApplicantID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereInvoiceID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeInvoicesItem whereUnitAmount($value)
 */
	class JamboreeInvoicesItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $troopID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePatrol whereTroopID($value)
 */
	class JamboreePatrol extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $userID
 * @property int $paymentType
 * @property float $amount
 * @property \Illuminate\Support\Carbon $paymentDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property string|null $notes
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePayment whereUserID($value)
 */
	class JamboreePayment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePaymentType whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePaymentType whereName($value)
 */
	class JamboreePaymentType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $userID
 * @property int|null $parentID
 * @property int $positionID
 * @property int $passportCountryID
 * @property int $passportCheck
 * @property string $notes
 * @property \Illuminate\Support\Carbon $created
 * @property int|null $offeredPosition
 * @property \Illuminate\Support\Carbon|null $offeredPositionDate
 * @property int|null $offeredPositionBy
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereOfferedPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereOfferedPositionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereOfferedPositionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereParentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered wherePassportCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered wherePassportCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered wherePositionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreePositionOffered whereUserID($value)
 */
	class JamboreePositionOffered extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property string $scouterPosition
 * @property string $scouterFirst
 * @property string $scouterSurname
 * @property string $scouterEmail
 * @property string $scouterCellNr
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereScouterCellNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereScouterEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereScouterFirst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereScouterPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereScouterSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeScouter whereUserID($value)
 */
	class JamboreeScouter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCamp whereName($value)
 */
	class JamboreeSubCamp extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property int $subCampID
 * @property int $troopID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation whereSubCampID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeSubCampTroopAllocation whereTroopID($value)
 */
	class JamboreeSubCampTroopAllocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $jamboreeID
 * @property string $name
 * @property int|null $subCampID
 * @property string $colour
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop whereJamboreeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroop whereSubCampID($value)
 */
	class JamboreeTroop extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $troopID
 * @property int|null $patrolID
 * @property int $roleID
 * @property int $active
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation wherePatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereTroopID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JamboreeTroopPatrolAllocation whereUserID($value)
 */
	class JamboreeTroopPatrolAllocation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $countryID
 * @property int|null $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|National whereName($value)
 */
	class National extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $groupID
 * @property int $districtID
 * @property int $regionID
 * @property int $countryID
 * @property string $title
 * @property string $description
 * @property string $extended
 * @property string $colour colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke
 * @property int $active
 * @property \Illuminate\Support\Carbon $doNotShowBefore
 * @property \Illuminate\Support\Carbon $doNotShowAfter
 * @property int $forType 1 = Group, 2 = District, 3 = Region, 4 = National
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property int $shown
 * @property \Illuminate\Support\Carbon|null $dismissDate
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDismissDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDoNotShowAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDoNotShowBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereExtended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereForType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereShown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserID($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $groupID
 * @property int $districtID
 * @property int $regionID
 * @property int $countryID
 * @property string $title
 * @property string $description
 * @property string $extended
 * @property string $colour colours are teal, amethyst, ruby, tangerine, lemon, lime, ebony, smoke
 * @property int $active
 * @property \Illuminate\Support\Carbon $doNotShowBefore
 * @property \Illuminate\Support\Carbon $doNotShowAfter
 * @property int $forType 1 = Group, 2 = District, 3 = Region, 4 = National
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property int $shown
 * @property \Illuminate\Support\Carbon|null $dismissDate
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereDismissDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereDoNotShowAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereDoNotShowBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereExtended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereForType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereShown($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationsArchive whereUserID($value)
 */
	class NotificationsArchive extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentType whereName($value)
 */
	class PaymentType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $projectForID
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $typeID
 * @property string $name
 * @property string $description
 * @property string $aim
 * @property \Illuminate\Support\Carbon $startDate
 * @property \Illuminate\Support\Carbon|null $endDate
 * @property string|null $document
 * @property string $contactPerson
 * @property string|null $contactEmail
 * @property string|null $contactCell
 * @property string|null $contactWebsite
 * @property int $active
 * @property int|null $approved
 * @property int|null $approvedby
 * @property \Illuminate\Support\Carbon|null $approveddate
 * @property int|null $declined
 * @property int|null $declinedby
 * @property \Illuminate\Support\Carbon|null $declineddate
 * @property string|null $declinedReason
 * @property string|null $declinedNotes
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereAim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereApprovedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereApproveddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContactCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContactWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDeclinedNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDeclinedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDeclineddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereProjectForID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereTypeID($value)
 */
	class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsFor whereName($value)
 */
	class ProjectsFor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $projectID
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereProjectID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectsSupported whereRegionID($value)
 */
	class ProjectsSupported extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $position
 * @property string $name
 * @property string|null $short
 * @property bool $usingAMS 1 = Yes, 0 = No
 * @property string $description
 * @property string $phys_address
 * @property int $countryID
 * @property bool $active
 * @property int $accountID
 * @property bool $censusDone
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $churchGroups
 * @property-read int|null $church_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $communityGroups
 * @property-read int|null $community_groups_count
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\District> $districts
 * @property-read int|null $districts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $dsdGroups
 * @property-read int|null $dsd_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $ngoGroups
 * @property-read int|null $ngo_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $schoolGroups
 * @property-read int|null $school_groups_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCensusDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region wherePhysAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereUsingAMS($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $assocToRegion
 * @property int $assocToDistrict
 * @property int $assocToGroup
 * @property \Illuminate\Support\Carbon $month
 * @property int $meerkatsM
 * @property int $meerkatsF
 * @property int|null $cubsM
 * @property int|null $cubsF
 * @property int|null $scoutsM
 * @property int|null $scoutsF
 * @property int|null $roversM
 * @property int|null $roversF
 * @property int $adultsDenM
 * @property int $adultsDenF
 * @property int|null $adultsPackM
 * @property int|null $adultsPackF
 * @property int|null $adultsTroopM
 * @property int|null $adultsTroopF
 * @property int $adultsCrewM
 * @property int $adultsCrewF
 * @property int|null $adultsGroupM
 * @property int|null $adultsGroupF
 * @property int|null $committee
 * @property int|null $helpers
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsCrewF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsCrewM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsDenF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsDenM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsGroupF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsGroupM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsPackF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsPackM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsTroopF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAdultsTroopM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereCommittee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereCubsF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereCubsM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereHelpers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereMeerkatsF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereMeerkatsM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereRoversF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereRoversM($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereScoutsF($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportsNumber whereScoutsM($value)
 */
	class ReportsNumber extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $roleID
 * @property string $review
 * @property string $reviewedFor
 * @property int $stars
 * @property int $active
 * @property int $approved
 * @property int|null $approvedby
 * @property \Illuminate\Support\Carbon|null $approvedDate
 * @property int $declined
 * @property int|null $declinedby
 * @property \Illuminate\Support\Carbon|null $declinedDate
 * @property string|null $declinedReason
 * @property string|null $declinedNotes
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereApprovedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereDeclined($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereDeclinedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereDeclinedNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereDeclinedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereDeclinedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereReviewedFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReview whereUserID($value)
 */
	class ScouterReview extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $reviewID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ScouterReviewsLike whereReviewID($value)
 */
	class ScouterReviewsLike extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $catID
 * @property int|null $groupID
 * @property string $title
 * @property string $slug
 * @property string $intro
 * @property string $article
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property string $createdby
 * @property int $views
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereCatID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticle whereViews($value)
 */
	class SdArticle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticleCat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticleCat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticleCat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticleCat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticleCat whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SdArticleCat whereSlug($value)
 */
	class SdArticleCat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $emailAddress
 * @property string $paymentType
 * @property float $amountInclVAT
 * @property string $serviceName
 * @property string $productDescription
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $processed
 * @property \Illuminate\Support\Carbon|null $processedDate
 * @property int $cancelled
 * @property \Illuminate\Support\Carbon|null $cancelledDate
 * @property int|null $groupID
 * @property \Illuminate\Support\Carbon|null $associatedToGroupDate
 * @property int|null $associatedToGroupBy
 * @property \Illuminate\Support\Carbon|null $startDate
 * @property \Illuminate\Support\Carbon|null $endDate
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereAmountInclVAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereAssociatedToGroupBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereAssociatedToGroupDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereCancelledDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereProcessedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereProductDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereServiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchased whereStartDate($value)
 */
	class ServicesPurchased extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $groupID
 * @property \Illuminate\Support\Carbon $receivedDate
 * @property string $location
 * @property int $addedBy
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsReceived whereReceivedDate($value)
 */
	class ServicesPurchasedSpreadsheetsReceived extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $groupID
 * @property \Illuminate\Support\Carbon $dateSent
 * @property int $sentBy
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent whereDateSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicesPurchasedSpreadsheetsSent whereSentBy($value)
 */
	class ServicesPurchasedSpreadsheetsSent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $year
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int|null $denID
 * @property int|null $packID
 * @property int|null $troopID
 * @property int|null $patrolID
 * @property int|null $crewID
 * @property string|null $scouterAskedAward
 * @property \Illuminate\Support\Carbon|null $scouterAskedAwardDate
 * @property int|null $scouterAskedAwardUserID
 * @property string|null $scouterMotivation
 * @property string|null $nptmRecommended
 * @property \Illuminate\Support\Carbon|null $nptmAskedAwardDate
 * @property int|null $nptmAskedAwardUserID
 * @property string|null $nptmMotivation
 * @property string|null $rtcRecommended
 * @property \Illuminate\Support\Carbon|null $rtcRecommendedDate
 * @property int|null $rtcRecommendedUserID
 * @property string|null $rtcMotivation
 * @property int|null $chairAwarded
 * @property \Illuminate\Support\Carbon|null $chairAwardedDate
 * @property int|null $chairAwardedUserID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereChairAwarded($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereChairAwardedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereChairAwardedUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereCrewID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereDenID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereNptmAskedAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereNptmAskedAwardUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereNptmMotivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereNptmRecommended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward wherePackID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward wherePatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereRtcMotivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereRtcRecommended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereRtcRecommendedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereRtcRecommendedUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereScouterAskedAward($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereScouterAskedAwardDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereScouterAskedAwardUserID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereScouterMotivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereTroopID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAward whereYear($value)
 */
	class StarAward extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $groupID
 * @property int|null $denID
 * @property int|null $packID
 * @property int|null $troopID
 * @property int|null $patrolID
 * @property int|null $crewID
 * @property int $noteType 1 = Group, 2 = District, 3 - Region, 4 = National
 * @property string $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereCrewID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereDenID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereNoteType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote wherePackID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote wherePatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StarAwardsNote whereTroopID($value)
 */
	class StarAwardsNote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $supportID
 * @property int $userID
 * @property int $direction 1 = From User, 2 = From Admin
 * @property string $chat
 * @property \Illuminate\Support\Carbon $created
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereChat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereSupportID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChat whereUserID($value)
 */
	class SupportChat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $answer
 * @property int $autoClose
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer whereAutoClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStandardAnswer whereId($value)
 */
	class SupportChatsStandardAnswer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $countryID
 * @property int $regionID
 * @property int $area
 * @property string $topic
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int|null $closed
 * @property \Illuminate\Support\Carbon|null $closedDate
 * @property int|null $closedBy
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereClosedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereClosedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsStart whereUserID($value)
 */
	class SupportChatsStart extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportChatsType whereName($value)
 */
	class SupportChatsType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketPriority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketPriority whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketPriority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketPriority whereName($value)
 */
	class SupportTicketPriority extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportTicketStatus whereName($value)
 */
	class SupportTicketStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAccountType whereName($value)
 */
	class SystemAccountType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsChallenge whereProgramType($value)
 */
	class SystemAdvancementCubsChallenge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property string $description
 * @property int $highLevel
 * @property int $investment
 * @property string|null $colour
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereHighLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereInvestment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsLevel whereProgramType($value)
 */
	class SystemAdvancementCubsLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property int $advancmentID
 * @property string|null $advancementArea
 * @property string $name
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereAdvancementArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereAdvancmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsSecond whereProgramType($value)
 */
	class SystemAdvancementCubsSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property int $advancmentID
 * @property int $secondID
 * @property string|null $challenge
 * @property int $theme
 * @property string|null $note
 * @property string $name
 * @property string $description
 * @property string|null $short
 * @property int $campingTask
 * @property int $badgeTask
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereAdvancmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereBadgeTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereCampingTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereChallenge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementCubsThird whereTheme($value)
 */
	class SystemAdvancementCubsThird extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsChallenge whereProgramType($value)
 */
	class SystemAdvancementMeerkatsChallenge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property string $description
 * @property int $highLevel
 * @property int $investment
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereHighLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereInvestment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsLevel whereProgramType($value)
 */
	class SystemAdvancementMeerkatsLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property int $advancmentID
 * @property string|null $advancementArea
 * @property string $name
 * @property string $short
 * @property string $description
 * @property int $badgeTask
 * @property int $theme
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereAdvancementArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereAdvancmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereBadgeTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsSecond whereTheme($value)
 */
	class SystemAdvancementMeerkatsSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property int $advancmentID
 * @property int $secondID
 * @property int $challenge
 * @property int|null $theme
 * @property string|null $note
 * @property string $name
 * @property string $description
 * @property string|null $short
 * @property int $campingTask
 * @property int $badgeTask
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereAdvancmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereBadgeTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereCampingTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereChallenge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereSecondID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementMeerkatsThird whereTheme($value)
 */
	class SystemAdvancementMeerkatsThird extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversChallenge whereProgramType($value)
 */
	class SystemAdvancementRoversChallenge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property string $description
 * @property string|null $htmlColor
 * @property int $highLevel
 * @property int $investment
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereHighLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereHtmlColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereInvestment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversLevel whereProgramType($value)
 */
	class SystemAdvancementRoversLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property int $advancmentID
 * @property int $theme
 * @property string $name
 * @property string $description
 * @property string|null $short
 * @property int $campingTask
 * @property int $badgeTask
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereAdvancmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereBadgeTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereCampingTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementRoversSecond whereTheme($value)
 */
	class SystemAdvancementRoversSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $scoutProgramTypeID
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property string $description
 * @property string|null $htmlColor
 * @property string|null $colour
 * @property int $highLevel
 * @property int $investment
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereHighLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereHtmlColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereInvestment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsLevel whereScoutProgramTypeID($value)
 */
	class SystemAdvancementScoutsLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $scoutProgramTypeID
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property int $advancmentID
 * @property int|null $theme
 * @property string|null $name
 * @property string $description
 * @property string|null $short
 * @property int $campingTask
 * @property int $badgeTask
 * @property string $oldID
 * @property int $active
 * @property int $PGATask
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereAdvancmentID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereBadgeTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereCampingTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereOldID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond wherePGATask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereScoutProgramTypeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecond whereTheme($value)
 */
	class SystemAdvancementScoutsSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $taskID
 * @property int $badgeID
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereBadgeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaBadge whereTaskID($value)
 */
	class SystemAdvancementScoutsSecondEntshaBadge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property string $themeName
 * @property string $description
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAdvancementScoutsSecondEntshaTheme whereThemeName($value)
 */
	class SystemAdvancementScoutsSecondEntshaTheme extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAssetCondition whereName($value)
 */
	class SystemAssetCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property string $description
 * @property string|null $htmlColor
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel whereHtmlColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemAwardsRoversLevel whereProgramType($value)
 */
	class SystemAwardsRoversLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $name
 * @property string|null $type
 * @property string|null $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsFirst whereType($value)
 */
	class SystemBadgeCubsFirst extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $firstID
 * @property string|null $heading
 * @property string $task
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeCubsSecond whereTask($value)
 */
	class SystemBadgeCubsSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $name
 * @property string $type
 * @property string|null $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsFirst whereType($value)
 */
	class SystemBadgeMeerkatsFirst extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $firstID
 * @property string|null $heading
 * @property string $task
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeMeerkatsSecond whereTask($value)
 */
	class SystemBadgeMeerkatsSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $type
 * @property string $name
 * @property string|null $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversFirst whereType($value)
 */
	class SystemBadgeRoversFirst extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $firstID
 * @property string|null $heading
 * @property string $task
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeRoversSecond whereTask($value)
 */
	class SystemBadgeRoversSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property string $type
 * @property string $name
 * @property string|null $note
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsFirst whereType($value)
 */
	class SystemBadgeScoutsFirst extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $programType
 * @property int $countryID
 * @property int $firstID
 * @property string|null $heading
 * @property string $task
 * @property int $position
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereFirstID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsSecond whereTask($value)
 */
	class SystemBadgeScoutsSecond extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $badgeID
 * @property int $toBadgeTaskID
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge whereBadgeID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemBadgeScoutsToBadge whereToBadgeTaskID($value)
 */
	class SystemBadgeScoutsToBadge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCity whereName($value)
 */
	class SystemCity extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCommitteeType whereName($value)
 */
	class SystemCommitteeType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCouncilType whereName($value)
 */
	class SystemCouncilType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $country_id
 * @property string $country_code
 * @property string $country_name
 * @property string|null $continent_name
 * @property string|null $region_name
 * @property int $usingSD
 * @property string|null $associationName
 * @property string|null $branch1Name
 * @property int|null $branch1ID
 * @property float $branch1StartingAge
 * @property float $branch1EndingAge
 * @property string|null $branch2Name
 * @property int|null $branch2ID
 * @property float $branch2StartingAge
 * @property float $branch2EndingAge
 * @property string|null $branch3Name
 * @property int|null $branch3ID
 * @property float $branch3StartingAge
 * @property float $branch3EndingAge
 * @property string|null $branch4Name
 * @property int|null $branch4ID
 * @property float $branch4StartingAge
 * @property float $branch4EndingAge
 * @property string|null $branch5Name
 * @property int|null $branch5ID
 * @property float $branch5StartingAge
 * @property float $branch5EndingAge
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereAssociationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch1EndingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch1ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch1Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch1StartingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch2EndingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch2ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch2Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch2StartingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch3EndingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch3ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch3Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch3StartingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch4EndingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch4ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch4Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch4StartingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch5EndingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch5ID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch5Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereBranch5StartingAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereContinentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCountryName whereUsingSD($value)
 */
	class SystemCountryName extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active 1 = Active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemCubsTask whereName($value)
 */
	class SystemCubsTask extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $youth
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemDocumentType whereYouth($value)
 */
	class SystemDocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $catID
 * @property int $targetID
 * @property string $q
 * @property string $a
 * @property int $active
 * @property int $position
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq whereA($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq whereCatID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq whereQ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaq whereTargetID($value)
 */
	class SystemFaq extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $faqGroup 1 = Scouters, 2 = Parents, 3 = Scouts, 4 = AMS
 * @property int $position
 * @property string $name
 * @property string|null $description
 * @property int $forNational
 * @property int $forRegion
 * @property int $forDistrict
 * @property int $forGroupAdults
 * @property int $forGroupParents
 * @property int $forGroupScouts
 * @property int $forGroupRovers
 * @property int $forAlumni
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereFaqGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForAlumni($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForGroupAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForGroupParents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForGroupRovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForGroupScouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForNational($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereForRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFaqCat wherePosition($value)
 */
	class SystemFaqCat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $canBeProrated 1 = Yes, 0 = No
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType whereCanBeProrated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemFinancialFeeType whereName($value)
 */
	class SystemFinancialFeeType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property int $position
 * @property string $name
 * @property int $active 1 = Active
 * @property int $groupType
 * @property int $districtType
 * @property int $regionalType
 * @property int $nationalType
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereDistrictType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereGroupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereNationalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupEventType whereRegionalType($value)
 */
	class SystemGroupEventType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $type
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemGroupManagementLevel whereType($value)
 */
	class SystemGroupManagementLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemParentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemParentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemParentType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemParentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemParentType whereName($value)
 */
	class SystemParentType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $area
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramType whereName($value)
 */
	class SystemProgramType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesCub whereName($value)
 */
	class SystemProgramTypesCub extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesMeerkat whereName($value)
 */
	class SystemProgramTypesMeerkat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesRover whereName($value)
 */
	class SystemProgramTypesRover extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemProgramTypesScout whereName($value)
 */
	class SystemProgramTypesScout extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $area
 * @property string $text
 * @property \Illuminate\Support\Carbon $releaseDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoadmapLittle whereText($value)
 */
	class SystemRoadmapLittle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverMeetingType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverMeetingType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverMeetingType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverMeetingType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverMeetingType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverMeetingType whereName($value)
 */
	class SystemRoverMeetingType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemRoverTask whereName($value)
 */
	class SystemRoverTask extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemScoutTask whereName($value)
 */
	class SystemScoutTask extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $maintenance
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereMaintenance($value)
 */
	class SystemSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property int $area
 * @property int $active
 * @property int $position
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemStarAwardType wherePosition($value)
 */
	class SystemStarAwardType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemTitle whereTitle($value)
 */
	class SystemTitle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $oldID
 * @property string|null $username
 * @property string|null $passwordNew
 * @property \Illuminate\Support\Carbon|null $lastPasswordChange
 * @property int|null $passwordChangedBy
 * @property \Illuminate\Support\Carbon|null $lastLoginDate
 * @property \Illuminate\Support\Carbon|null $startDate
 * @property string|null $title
 * @property string|null $first_name
 * @property string|null $otherName
 * @property string|null $surname
 * @property string|null $previousSurname
 * @property string|null $knownName
 * @property string|null $scoutName
 * @property string|null $photo
 * @property string|null $thumb
 * @property string|null $idNumber
 * @property string|null $IDBookLocation
 * @property string|null $passportNumber
 * @property int|null $passportCountry
 * @property string|null $partnersFullName
 * @property string|null $sex
 * @property string|null $race
 * @property \Illuminate\Support\Carbon|null $dob
 * @property \Illuminate\Support\Carbon|null $dateInvested
 * @property int $multiID
 * @property int|null $packID
 * @property int|null $troopID
 * @property \Illuminate\Support\Carbon|null $dateToCubs
 * @property \Illuminate\Support\Carbon|null $dateToScouts
 * @property int|null $scoutPatrolID
 * @property int|null $scoutPatrolTaskID
 * @property \Illuminate\Support\Carbon|null $dateToRovers
 * @property string|null $phys_address
 * @property string|null $gpsLat
 * @property string|null $gpsLon
 * @property string|null $gpsAccuracy
 * @property int $phys_country_id
 * @property string|null $postal_address
 * @property int|null $postal_country_id
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property int|null $user_type
 * @property int|null $parentType
 * @property int $active 1 = active
 * @property \Illuminate\Support\Carbon|null $dateDeactivated
 * @property int|null $deactivatedBy
 * @property int $assoc_to_account
 * @property int|null $assoc_to_group
 * @property string|null $branch
 * @property int|null $assoc_to_district
 * @property int|null $assoc_to_region
 * @property string|null $trainingRegionName
 * @property string|null $trainingDistrictName
 * @property string|null $trainingGroupName
 * @property string|null $language
 * @property string|null $cellNr
 * @property string|null $officeNr
 * @property string|null $homeNr
 * @property string|null $faxNr
 * @property int|null $responsible_for_payment 1 = Yes
 * @property int|null $mustChangePassword 1 = Must change password
 * @property int $canLogon 1 = Can Logon
 * @property string|null $medicalAidName
 * @property string|null $medicalAidNr
 * @property string|null $medicalAidPrincipalMember
 * @property string|null $doctorsName
 * @property string|null $doctorsPhone
 * @property string|null $allergies
 * @property string|null $allergiesInstructions
 * @property string|null $disabilities
 * @property string|null $disabilitiesInstructions
 * @property string|null $medicalConditions
 * @property string|null $medicalConditionsInstructions
 * @property string|null $currentMedication
 * @property string|null $emergencyContactName
 * @property string|null $emergencyContactCell
 * @property string|null $emergencyContactTel
 * @property string|null $emergencyContactRelationship
 * @property string|null $specialMealRequirements
 * @property string|null $religiousAffilliation
 * @property string|null $school
 * @property string|null $religion
 * @property string|null $religiousAffiliation
 * @property string|null $hobbies
 * @property string|null $sports
 * @property string|null $interests
 * @property int $canAdmin
 * @property string|null $100CharID
 * @property int|null $uniquePIN
 * @property int $weeklyEmailUnsubscribe
 * @property string|null $weeklyEmailUnsubscribeText
 * @property \Illuminate\Support\Carbon|null $weeklyEmailUnsubscribeDate
 * @property int|null $logonEmailSent 1 = Yes
 * @property \Illuminate\Support\Carbon|null $LogonEmailDate
 * @property int $amsOnly 1 = Only AMS
 * @property int $amsRole
 * @property int|null $homeLanguage
 * @property int|null $otherLanguage
 * @property string|null $otherLanguages
 * @property int|null $proficiencyInEnglish
 * @property string|null $religiousBelief
 * @property int|null $highestEducation
 * @property int|null $nrOfChildrenBoys
 * @property int|null $nrOfChildrenGirls
 * @property string|null $occupation
 * @property string|null $typeOfEmployment
 * @property string|null $employer
 * @property int|null $maritalStatus
 * @property string|null $ref1Name
 * @property string|null $ref1Address
 * @property string|null $ref1Tel
 * @property string|null $ref2Name
 * @property string|null $ref2Address
 * @property string|null $ref2Tel
 * @property int|null $newsletterUnsubscribe
 * @property \Illuminate\Support\Carbon|null $newsletterUnsubscribeDate
 * @property int|null $reportView
 * @property int|null $roverGroupID
 * @property int|null $roverGroupRoleID
 * @property int|null $roverGroupAccountID
 * @property int|null $24WSJ
 * @property int|null $24WSJRole
 * @property string|null $24wsjNotListedDistrict
 * @property string|null $24wsjNotListedGroup
 * @property int $SANJamb2017
 * @property string $SANJamb2017Role
 * @property string|null $sanJambNotListedRegion
 * @property string|null $sanJambNotListedDistrict
 * @property string|null $sanJambNotListedGroup
 * @property int $infoRedacted 0 = Not Redacted, 1 = Redacted on screen
 * @property string|null $SSANumber
 * @property int $orphaned
 * @property int $vulnerable
 * @property int $sendAMSMail
 * @property string|null $generalNotes
 * @property int $form29Generated
 * @property int $logonEmail
 * @property int $weeklyProgramEmail
 * @property int $profileChangesEmail
 * @property int $newsletterEmail
 * @property int $lowerStaffProfileChanges
 * @property int $loggedInTo20
 * @property int $canLogonTo20
 * @property int $adultRecruit
 * @property int $addedIn
 * @property int $canAdminElearning
 * @property int $canAdminElearningCourses
 * @property int $view 1 = Line, 2 = Grid
 * @property int|null $docsDeleted
 * @property int|null $takenSurvey
 * @property int $ddValue
 * @property string|null $DSDHostelName
 * @property string|null $DSDTownshipName
 * @property int|null $DSDDisabled
 * @property-read mixed $name
 * @property-read mixed $ssa_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser where100CharID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser where24WSJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser where24WSJRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser where24wsjNotListedDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser where24wsjNotListedGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAddedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAdultRecruit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAllergiesInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAmsOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAmsRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAssocToAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAssocToDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAssocToGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereAssocToRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCanAdminElearning($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCanAdminElearningCourses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCanLogon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCanLogonTo20($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCellNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereCurrentMedication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDSDDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDSDHostelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDSDTownshipName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDateDeactivated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDateInvested($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDateToCubs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDateToRovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDateToScouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDdValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDeactivatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDisabilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDisabilitiesInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDocsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDoctorsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereDoctorsPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereEmergencyContactCell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereEmergencyContactRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereEmergencyContactTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereEmployer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereFaxNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereForm29Generated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereGeneralNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereGpsAccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereGpsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereGpsLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereHighestEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereHobbies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereHomeLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereHomeNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereIDBookLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereIdNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereInfoRedacted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereInterests($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereKnownName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLastLoginDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLastPasswordChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLoggedInTo20($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLogonEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLogonEmailDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLogonEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereLowerStaffProfileChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMedicalAidName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMedicalAidNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMedicalAidPrincipalMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMedicalConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMedicalConditionsInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMultiID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereMustChangePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereNewsletterEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereNewsletterUnsubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereNewsletterUnsubscribeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereNrOfChildrenBoys($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereNrOfChildrenGirls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOfficeNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOldID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOrphaned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOtherLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOtherLanguages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereOtherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePackID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereParentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePartnersFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePassportCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePasswordChangedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePasswordNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePhysAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePhysCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePostalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePostalCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser wherePreviousSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereProficiencyInEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereProfileChangesEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRef1Address($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRef1Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRef1Tel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRef2Address($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRef2Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRef2Tel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereReligion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereReligiousAffiliation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereReligiousAffilliation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereReligiousBelief($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereReportView($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereResponsibleForPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRoverGroupAccountID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRoverGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereRoverGroupRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSANJamb2017($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSANJamb2017Role($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSSANumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSanJambNotListedDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSanJambNotListedGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSanJambNotListedRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereScoutName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereScoutPatrolID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereScoutPatrolTaskID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSendAMSMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSpecialMealRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSports($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTakenSurvey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTrainingDistrictName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTrainingGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTrainingRegionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTroopID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereTypeOfEmployment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereUniquePIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereView($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereVulnerable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereWeeklyEmailUnsubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereWeeklyEmailUnsubscribeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereWeeklyEmailUnsubscribeText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser whereWeeklyProgramEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUser withPlainPassword()
 */
	class SystemUser extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $countryID
 * @property int|null $regionID
 * @property int|null $districtID
 * @property int|null $groupID
 * @property int|null $userID
 * @property string $page
 * @property string $IP
 * @property string|null $userAgent
 * @property string|null $post
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereIP($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging wherePost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserLogging whereUserID($value)
 */
	class SystemUserLogging extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $name
 * @property string $description
 * @property int $sysAdmin
 * @property int $nationalRole
 * @property int $regionalRole
 * @property int $superDistrictRole
 * @property int $districtRole
 * @property int $groupRole
 * @property int $denRole
 * @property int $packRole
 * @property int $troopRole
 * @property int $crewRole
 * @property int $adultLeaderRole
 * @property int $parentHelperRole
 * @property int $alumniRole
 * @property int $warrantedRole
 * @property int $appointmentRole
 * @property int $requiresCriminalClearance
 * @property int|null $signsLeft
 * @property int|null $signsRight
 * @property int $chargeRole
 * @property int $active
 * @property int $position
 * @property int $canAdminAlumni
 * @property int $canSeeAlumni
 * @property int $canAdminNational
 * @property int $canSeeNational
 * @property int $canAdminRegion
 * @property int $canSeeRegion
 * @property int $canAdminRegionKids
 * @property int $canAdminRegionTraining
 * @property int $canAdminSuperDistrict
 * @property int $canSeeSuperDistrict
 * @property int $canAdminDistrict
 * @property int $canSeeDistrict
 * @property int $canAdminDistrictKids
 * @property int $canAdminGroup
 * @property int $canSeeGroup
 * @property int $canAdminGroupAdults
 * @property int $canAwardGroupMeerkats
 * @property int $canAwardGroupCubs
 * @property int $canAwardGroupScouts
 * @property int $canAwardGroupRovers
 * @property int $canSeeSupport
 * @property int $canAdminSupport
 * @property int $canAddWarrants
 * @property int $canAdminProperty
 * @property int $canSignWarrants
 * @property int $canAdminForm29
 * @property int $canAdminPoliceClearance
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereAdultLeaderRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereAlumniRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereAppointmentRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAddWarrants($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminAlumni($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminDistrictKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminForm29($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminGroupAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminNational($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminPoliceClearance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminRegionKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminRegionTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminSuperDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAdminSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAwardGroupCubs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAwardGroupMeerkats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAwardGroupRovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanAwardGroupScouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeAlumni($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeNational($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeSuperDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSeeSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCanSignWarrants($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereChargeRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereCrewRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereDenRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereDistrictRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereGroupRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereNationalRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType wherePackRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereParentHelperRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereRegionalRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereRequiresCriminalClearance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereSignsLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereSignsRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereSuperDistrictRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereSysAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereTroopRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUserType whereWarrantedRole($value)
 */
	class SystemUserType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property string $emailAddress
 * @property int $emailFailedVerification
 * @property \Illuminate\Support\Carbon|null $dateVerified
 * @property string|null $response
 * @property string|null $responseHeading
 * @property \Illuminate\Support\Carbon|null $sentConfirmationEmail
 * @property string|null $subjectReceivedBack
 * @property string|null $messageReceivedBack
 * @property \Illuminate\Support\Carbon|null $messageReceivedBackDate
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereDateVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereEmailFailedVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereMessageReceivedBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereMessageReceivedBackDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereResponseHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereSentConfirmationEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereSubjectReceivedBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmailVerification whereUserID($value)
 */
	class SystemUsersEmailVerification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property string|null $contact1Title
 * @property string $contact1FirstName
 * @property string $contact1Surname
 * @property string $contact1Cell
 * @property string|null $contact1Home
 * @property string|null $contact1Work
 * @property int|null $contact1Relationship
 * @property string|null $contact2Title
 * @property string $contact2FirstName
 * @property string $contact12urname
 * @property string $contact2Cell
 * @property string|null $contact2Home
 * @property string|null $contact2Work
 * @property int|null $contact2Relationship
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact12urname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1Cell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1FirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1Home($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1Relationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1Surname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1Title($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact1Work($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact2Cell($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact2FirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact2Home($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact2Relationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact2Title($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereContact2Work($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersEmergencyContact whereUserID($value)
 */
	class SystemUsersEmergencyContact extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $userID
 * @property string|null $agent
 * @property string|null $ipAddress
 * @property \Illuminate\Support\Carbon $created
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersFingerprint whereUserID($value)
 */
	class SystemUsersFingerprint extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property int $userID
 * @property string $fromURL
 * @property string $toURL
 * @property string|null $IPAddress
 * @property string|null $extended
 * @property string|null $userAgent
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereExtended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereFromURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereIPAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereToURL($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForcedLogout whereUserID($value)
 */
	class SystemUsersForcedLogout extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property string $PDFLocation
 * @property \Illuminate\Support\Carbon|null $sentToDSD
 * @property string|null $DSDResponse
 * @property string|null $DSDResponseNotes
 * @property \Illuminate\Support\Carbon|null $DSDResponseDate
 * @property int|null $DSDResponseBy
 * @property int $active
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereDSDResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereDSDResponseBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereDSDResponseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereDSDResponseNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 wherePDFLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereSentToDSD($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersForm29 whereUserID($value)
 */
	class SystemUsersForm29 extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $countryID
 * @property int $regionID
 * @property int|null $superDistrictID
 * @property int $districtID
 * @property int $groupID
 * @property int $roleID
 * @property int $defaultRole
 * @property int $active
 * @property string|null $creationNotes
 * @property int $actionCountryID
 * @property int $actionRegionID
 * @property int $actionSuperDistrictID
 * @property int $actionDistrictID
 * @property int $actionGroupID
 * @property int $retired
 * @property int $resigned
 * @property int $suspended
 * @property int $multiID
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereActionCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereActionDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereActionGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereActionRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereActionSuperDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereCreationNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereDefaultRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereMultiID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereResigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereRetired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereSuperDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereSuspended($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersOtherRole whereUserID($value)
 */
	class SystemUsersOtherRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $username
 * @property \Illuminate\Support\Carbon $date
 * @property string $emailed
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed whereEmailed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUsersPasswordsEmailed whereUsername($value)
 */
	class SystemUsersPasswordsEmailed extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $countryID
 * @property string $fromText
 * @property string $toText
 * @property int $active
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereFromText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translation whereToText($value)
 */
	class Translation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $userID
 * @property int $roleID
 * @property int $active
 * @property int $passportCountryID
 * @property int $passportChecked
 * @property int $countryID
 * @property int $regionID
 * @property int $districtID
 * @property int $groupID
 * @property int $applyRoleID
 * @property int $invested
 * @property \Illuminate\Support\Carbon $created
 * @property int $createdby
 * @property \Illuminate\Support\Carbon|null $modified
 * @property int|null $modifiedby
 * @property-read \App\Models\SystemUser|null $createdBy
 * @property-read \App\Models\SystemUser|null $modifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereApplyRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereCreatedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereDistrictID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereGroupID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereInvested($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereModifiedby($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression wherePassportChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression wherePassportCountryID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereRegionID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereRoleID($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Wsm16Expression whereUserID($value)
 */
	class Wsm16Expression extends \Eloquent {}
}

