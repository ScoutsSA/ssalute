<?php

namespace App\Http\Controllers;

use App\Models\SystemUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScoutsDigitalImpersonateController extends Controller
{
    public function __invoke(Request $request, SystemUser $user): View
    {
        abort_unless($request->hasValidSignature(), 403, 'Invalid or expired signature.');
        abort_unless($request->user()?->isSuperAdmin(), 403, 'Unauthorized.');

        Log::info('Impersonate on SD via signed URL', [
            'admin_id' => $request->user()->id,
            'target_username' => $user->username,
        ]);

        $url = config('ssalute.scouts_digital_url') . '/includes/logon-action.php';
        $username = $user->username;
        $password = $user->getScoutsDigitalPlainTextPassword();

        return view('impersonate.scouts-digital', [
            'url' => $url,
            'username' => $username,
            'password' => $password,
        ]);
    }
}
