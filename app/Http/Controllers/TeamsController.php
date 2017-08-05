<?php

namespace App\Http\Controllers;

use App\Teams;

class TeamsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $teams = Teams::where('id', '<=', '40')->get();
        $teams = $teams->sortByDesc(function ($team) {
            return $team->avg;
        });

        return view('/teams', compact('teams'));
    }

    public function team2k2()
    {
        $teams = Teams::where('id', '>', '40')->get();
        $teams = $teams->sortByDesc(function ($team) {
            return $team->avg;
        });

        return view('/teams', compact('teams'));
    }

    public function team(Teams $team)
    {
        $members = $team->users;

        return view('/team', compact('members'));
    }
}
