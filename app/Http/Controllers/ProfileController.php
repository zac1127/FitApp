<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Week;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        $id = $user->id;
        $post_sum = Post::where('user_id', $id)->sum('points');
        $posts = Post::where('user_id', $id)->distinct()->orderBy('updated_at', 'desc')->paginate(10);

        /*this weeks points*/
        $week = Week::orderBy('created_at', 'asc')->get()->last();
        $week_start_date = $week->created_at;

        return view('profile', compact('user', 'posts', 'post_sum', 'week_start_date'));
    }

    public function add_profile_picture(Request $request)
    {
        $image = Input::file('image');
        $filename = time().'-'.$image->getClientOriginalName();
        $image->move(public_path().'/images/', $filename);
        $path = public_path('/images/'.$filename);
        Image::make($path)->fit(400, 400)->orientate()->save($path);

        $user_id = Auth::user()->id;

        $user = User::where('id', $user_id)->update(['profile_picture' => $filename]);

        return redirect('/profile/'.$user_id);
    }
}
