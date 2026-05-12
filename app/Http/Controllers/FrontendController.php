<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function ourTeam()
    {
        return view('home.team.team_page');
    } // End Method
}
