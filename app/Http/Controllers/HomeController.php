<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Teams;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::distinct()->orderBy('updated_at', 'desc')->paginate(15);

        return view('home', compact('posts', 'user', 'team'));
    }

    public function add_family_member()
    {
        return view('/add_family_member');
    }

    public function add_member(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $team_id = Auth::user()->teams_id;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->teams_id = 0;
        $user->team_leader = 0;
        $user->family_member = 1;
        $user->profile_picture = 'profile.jpg';
        $user->save();

        return redirect('/home');
    }

    public function shirts()
    {
        $users = User::orderBy('name', 'asc')->get();
        $xs = User::where('shirt_size', '=', 'XS')->count();
        $s = User::where('shirt_size', '=', 'S')->count();
        $m = User::where('shirt_size', '=', 'M')->count();
        $l = User::where('shirt_size', '=', 'L')->count();
        $xl = User::where('shirt_size', '=', 'XL')->count();
        $xxl = User::where('shirt_size', '=', 'XXL')->count();

        return view('/shirts', compact('users', 'xs', 's', 'm', 'l', 'xl', 'xxl'));
    }

    public function points()
    {

        //contract Team
        $staff_teams = Teams::where('id', '<=', '40')->get();
        $staff_teams = $staff_teams->sortByDesc(function ($team) {
            return $team->avg;
        });

        // staff personal
        $users_staff = User::where('teams_id', '<=', '40')->get();
        $users_staff = $users_staff->sortByDesc(function ($user) {
            return $user->points;
        });

        //contract Team
        $contract_teams = Teams::where('id', '>', '40')->get();
        $contract_teams = $contract_teams->sortByDesc(function ($team) {
            return $team->avg;
        });

        // 2k2 personal
        $users_contract = User::where('teams_id', '>', '40')->get();
        $users_contract = $users_contract->sortByDesc(function ($user) {
            return $user->points;
        });

        return view('/points', compact('users_staff', 'users_contract', 'staff_teams', 'contract_teams'));
    }

}
