<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Post;

class CalendarController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $dates_posted = Post::where('user_id', $user_id)->pluck('submit_date')->toArray();

        return view('/calendar', compact('dates_posted'));
    }
}
