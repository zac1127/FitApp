<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }

    public function comments(Post $post)
    {
        // Return the comments associated with the Post.
        $comments = $post->comments;

        return view('comments', compact('comments', 'post'));
    }

    public function post(Request $request)
    {

        /*
        * Form Validation
        */
        if ($request->sugar_check_box == 'on' || $request->grain_check_box == 'on' || $request->water_check_box == 'on') {
            $this->validate($request, [
            'journal_nutrition' => 'required',
        ]);
        }

        if ($request->exercise_check_box == 'on') {
            $this->validate($request, [
            'journal_exercise' => 'required',
        ]);
        }

        if ($request->bible_study_check_box == 'on') {
            $this->validate($request, [
            'journal_bible' => 'required',
        ]);
        }

        // Get the users ID
        $user_id = Auth::user()->id;

        /*
        * If the checkbox to log for yesterday is checked,
        * set the submit date the the day before else
        * set it to today.
        */
        if ($request->log_for_yesterday == 'on') {
            $submit_date = Carbon::yesterday()->format('n-d-Y');
        } else {
            $submit_date = Carbon::today()->format('n-d-Y');
        }

        /*
        * If already posted to the submit date,
        * update the previous post, else make
        * a new post.
        */
        if (Post::alreadyPosted($submit_date)) {
            Post::updatePost($request);
        } else {
            Post::newPost($request);
        }

        if (Auth::user()->shirt_size == null) {
            Post::setTshirtSize($request);
        }

        if (Auth::user()->message_seen == 0 || Auth::user()->message_seen == null) {
            User::where('id', $user_id)->update(['message_seen' => '1']);
        }

        // Return the user to their profile.
        return redirect('/profile/'.$user_id);
    }

    public function add_comment(Request $request)
    {
        $this->validate($request, ['comment' => 'required']);

        $comment = new Comment();
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        $ajax = array();
        $ajax['post_id'] = $request->post_id;
        $ajax['profile_image'] = Auth::user()->profile_picture;
        $ajax['user_id'] = Auth::user()->id;
        $ajax['user_name'] = Auth::user()->name;
        $ajax['comment'] = $request->comment;

        return json_encode($ajax);
    }
}
