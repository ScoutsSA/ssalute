<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use Illuminate\Http\Request;

class ApplicationAdultMembershipController extends Controller
{
    public function viewAamPage(Request $request, string $aam_actionable_slug)
    {
        $aamRequest = ApplicationAdultMembershipRequest::where('action_slug', $aam_actionable_slug)->firstOrFail();

        return view('forms.aam.aam_approval', ['aamRequest' => $aamRequest]);
    }
}
