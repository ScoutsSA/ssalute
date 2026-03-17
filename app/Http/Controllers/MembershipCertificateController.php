<?php

namespace App\Http\Controllers;

use App\Models\MembershipCertificate;
use App\Services\FileUrlService;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\View\View;

class MembershipCertificateController
{
    public function __invoke(string $uuid): View
    {
        $certificate = MembershipCertificate::where('uuid', $uuid)
            ->firstOrFail();

        $user = $certificate->user;
        abort_unless($user, 404);
        $visibleFields = $certificate->visible_fields;

        $activeRoles = $user->activeRoleAttachments()
            ->with(['role', 'region', 'district', 'group'])
            ->get();

        $isActiveMember = MembershipCertificate::userHasEligibleRoles($activeRoles);

        $photoUrl = null;
        if (in_array('photo', $visibleFields) && $user->photo) {
            $photoUrl = app(FileUrlService::class)->url($user->photo);
        }

        $qrCode = (new QRCode(new QROptions([
            'outputType' => QROutputInterface::MARKUP_SVG,
            'svgUseCssProperties' => false,
            'drawLightModules' => false,
            'addQuietzone' => true,
            'scale' => 5,
        ])))->render(route('membership-certificate.show', $certificate->uuid));

        return view('membership-certificate.show', [
            'certificate' => $certificate,
            'user' => $user,
            'visibleFields' => $visibleFields,
            'activeRoles' => $activeRoles,
            'isActiveMember' => $isActiveMember,
            'photoUrl' => $photoUrl,
            'qrCode' => $qrCode,
        ]);
    }
}
