<?php

namespace App\Http\Controllers;

use App\Models\ApplicationAdultMembershipRequest;
use Illuminate\Http\Request;

class ApplicationAdultMembershipController extends Controller
{
    public function checkUserExistencePage()
    {
        if (config('features.aam.check-user-existence.enabled') !== true) {
            abort(404);
        }

        return view('aam.check-existence');
    }

    public function aamRegisterPage()
    {
        if (config('features.aam.aam_form.enabled') !== true) {
            abort(404);
        }

        return view('aam.aam_form');
    }

    public function viewAamPage(Request $request, string $aam_actionable_slug)
    {
        if (config('features.aam.aam_form.enabled') !== true) {
            abort(404);
        }
        $aamRequest = ApplicationAdultMembershipRequest::where('action_slug', $aam_actionable_slug)->firstOrFail();

        return view('aam.aam_approval', ['aamRequest' => $aamRequest]);
    }
}
