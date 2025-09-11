<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function welcomePage()
    {
        return view('welcome', [
            'title' => 'Ssalute - Home',
        ]);
    }
}
