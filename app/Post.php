<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Post extends Model
{


/*----------------------------------------
  *          Database Relationships
  *-----------------------------------------*/
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*----------------------------------------
    *           Functions Declared
    *-----------------------------------------*/

    public static function formatDateForPost($date)
    {
        $split = explode('-', $date);
        $month = $split[0];
        $day = $split[1];

        switch ($month) {
          case 1: $month = 'Jan'; break;
          case 2: $month = 'Feb'; break;
          case 3: $month = 'Mar'; break;
          case 4: $month = 'Apr'; break;
          case 5: $month = 'May'; break;
          case 6: $month = 'Jun'; break;
          case 7: $month = 'Jul'; break;
          case 8: $month = 'Aug'; break;
          case 9: $month = 'Sep'; break;
          case 10: $month = 'Oct'; break;
          case 11: $month = 'Nov'; break;
          case 12: $month = 'Dec'; break;
        }

        $date = $month.' '.$day;

        return $date;
    }

    /**
     * Checks whether the user has made a post
     * for a given date. Returns boolean.
     */
    public static function alreadyPosted($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['submit_date', '=', $date],
        ])->exists();
    }

    /**
     * Checks whether the user has posted a
     * post for today. Returns a boolean.
     */
    public static function getPost()
    {
        $date = Carbon::today()->format('n-d-Y');

        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['submit_date', '=', $date],
        ])->orderBy('created_at', 'desc')->get()->first();
    }

    /**
     * Given a date, returns that days post.
     */
    public static function getPostFromDate($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['submit_date', '=', $date],
        ])->orderBy('created_at', 'desc')->get()->first();
    }

    /**
     * Checks if water has been checked for a given Date
     * returns boolean.
     */
    public static function checkWater($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['water', '=', 1],
        ['submit_date', '=', $date],
        ])->exists();
    }

    /**
     * Checks if grain has been checked for a given Date
     * returns boolean.
     */
    public static function checkGrain($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['grain', '=', 1],
        ['submit_date', '=', $date],
        ])->exists();
    }

    /**
     * Checks if sugar has been checked for a given Date
     * returns boolean.
     */
    public static function checkSugar($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['sugar', '=', 1],
        ['submit_date', '=', $date],
        ])->exists();
    }

    /**
     * Checks if exercise has been checked for a given Date
     * returns boolean.
     */
    public static function checkExercise($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['workout', '=', 1],
        ['submit_date', '=', $date],
        ])->exists();
    }

    /**
     * Checks if bible study has been checked for a given Date
     * returns boolean.
     */
    public static function checkBibleStudy($date)
    {
        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['bible_study', '=', 1],
        ['submit_date', '=', $date],
        ])->exists();
    }

    /**
     * Returns the number of times exercise has been
     * submitted within the week returns number of posts.
     */
    public static function exerciseWeek($date)
    {
        $week = Week::orderBy('id', 'desc')->first();

        if ($date < $week->created_at) {
            $last_week = Week::orderBy('id', 'desc')->skip(1)->first();

            return self::where([
            ['user_id', '=', Auth::user()->id],
            ['workout', '=', 1],
            ['created_at', '>', $last_week->created_at],
            ['created_at', '<', $week->created_at],
            ])->count();
        }

        return self::where([
        ['user_id', '=', Auth::user()->id],
        ['workout', '=', 1],
        ['created_at', '>', $week->created_at],
        ])->count();
    }

    /**
     * Creates a new post.
     */
    public static function newPost($request)
    {
        /*----------------------------------------
      * variables assigned
      /*----------------------------------------*/

      if ($request->log_for_yesterday == 'on') {
          $created_at = Carbon::yesterday();
          $submit_date = Carbon::yesterday()->format('n-d-Y');
      } else {
          $created_at = Carbon::now();
          $submit_date = Carbon::today()->format('n-d-Y');
      }

        $now = Carbon::now();
        $user_id = Auth::user()->id;
        $team_id = Auth::user()->teams_id;
        $water = 0;
        $grain = 0;
        $sugar = 0;
        $exercise = 0;
        $bible_study = 0;
        $points = 0;

      /*
      *  Add points for each achievment
      */

      if ($request->sugar_check_box == 'on') {
          $sugar = 1;
          ++$points;
      }
        if ($request->grain_check_box == 'on') {
            $grain = 1;
            ++$points;
        }
        if ($request->water_check_box == 'on') {
            $water = 1;
            ++$points;
        }
        if ($request->exercise_check_box == 'on' &&
          self::exerciseWeek($submit_date) < 6) {
            $exercise = 1;
            ++$points;
        }

        if ($request->bible_study_check_box == 'on') {
            $bible_study = 1;
            ++$points;
        }

        $totalPoints = $points + User::pointsThisWeek($user_id);
        if($totalPoints > 26) {
            $points = 26 - User::pointsThisWeek($user_id);
        }


      /*
      * Create the post for the user
      */
      $post = new self();
        $post->user_id = $user_id;
        $post->team_id = $team_id;
        $post->journal_nutrition = $request->journal_nutrition;
        $post->journal_exercise = $request->journal_exercise;
        $post->journal_bible_study = $request->journal_bible;
        $post->water = $water;
        $post->grain = $grain;
        $post->sugar = $sugar;
        $post->workout = $exercise;
        $post->bible_study = $bible_study;
        $post->points = $points;
        $post->submit_date = $submit_date;
        $post->created_at = $created_at;
        $post->updated_at = $now;
        $post->save();

        if ($team_id > 0) {
         /*
          * Update the teams points
          * New post is already saved in the database
          * So all we need to do is sum up the teams points.
          */
          $total = self::where('team_id', $team_id)->sum('points');
            // update the teams points
          Teams::where('id', $team_id)->update(['points' => $total]);
        }
    }

    /*
    * Update a post
    */
    public static function updatePost($request)
    {
        /**
         * Data Dictionary.
         */
        $user_id = Auth::user()->id;
        $team_id = Auth::user()->teams_id;
        $points = 0;

        if ($request->log_for_yesterday == 'on') {
            $created_at = Carbon::yesterday();
            $submit_date = Carbon::yesterday()->format('n-d-Y');
        } else {
            $created_at = Carbon::now();
            $submit_date = Carbon::today()->format('n-d-Y');
        }

        $post_id = self::getPostFromDate($submit_date)->id;

        /*
        * The if statements below check whether the check box has been checked
        * and also validates that the user has not already claimed that
        * achievment for the date that they are posting for.
        */

        if ($request->sugar_check_box == 'on') {
            self::where('id', $post_id)->update(['sugar' => 1]);
            ++$points;
        }
        if ($request->grain_check_box == 'on') {
            self::where('id', $post_id)->update(['grain' => 1]);
            ++$points;
        }
        if ($request->water_check_box == 'on') {
            self::where('id', $post_id)->update(['water' => 1]);
            ++$points;
        }

        if ($request->exercise_check_box == 'on' &&
            self::exerciseWeek($submit_date) < 6) {
            self::where('id', $post_id)->update(['workout' => 1]);
            ++$points;
        }

        if ($request->bible_study_check_box == 'on') {
            self::where('id', $post_id)->update(['bible_study' => 1]);
            ++$points;
        }

        /**
         * Gets the number of points already applied to that post
         * and adds the new points to the variable.
         */
        $post_total_points = self::where('id', $post_id)->pluck('points')[0] + $points;


        $totalPoints = $post_total_points + User::pointsThisWeek($user_id);
        if($totalPoints > 26) {
            $post_total_points = 26 - User::pointsThisWeek($user_id);
        }


        /*
        * Update the post where id = $post_id
        * Updates the journal entries.
        * and then finally sets the points = $post_total_points
        * declared above.
        */

        self::where('id', $post_id)->update([
          'journal_nutrition' => $request->journal_nutrition,
          'journal_exercise' => $request->journal_exercise,
          'journal_bible_study' => $request->journal_bible,
          'updated_at' => $created_at,
          'points' => $post_total_points,
        ]);

        if ($team_id > 0) {
            /**
           * Then we sum up the teams points, and update the
           * points in the teams database.
           */
          $total = self::where('team_id', $team_id)->sum('points');
          // update the teams points
          Teams::where('id', $team_id)->update(['points' => $total]);
        }
    }

    public static function setTshirtSize($request)
    {
        $user_id = Auth::user()->id;

        if ($request->xsmall_check_box == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'XS']);
        }

        if ($request->small_check_box == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'S']);
        }

        if ($request->medium_check_box == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'M']);
        }

        if ($request->large_check_box == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'L']);
        }

        if ($request->xlarge_check_box == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'XL']);
        }

        if ($request->xxlarge_check_box == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'XXL']);
        }

        if ($request->no_shirt_wanted == 'on') {
            User::where('id', $user_id)->update(['shirt_size' => 'N']);
        }
    }
}
