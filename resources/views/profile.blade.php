@extends('layouts.app')

@section('content')


<div class="header">
  <div class="title">
    {{$user->name}}
  </div>
  <div class="settings-icon-container">
    <div class="icon-settings"></div>
  </div>
</div>


<?php
/*
* Determine possible points
*/
$day = Carbon\Carbon::today()->format('D');
$points_possible = 0;
$challenge_percent = 0;

switch ($day) {
  case 'Tue': $points_possible = 5;
  break;
  case 'Wed': $points_possible = 10;
  break;
  case 'Thu': $points_possible = 15;
  break;
  case 'Fri': $points_possible = 20;
  break;
  case 'Sat': $points_possible = 25;
  break;
  case 'Sun': $points_possible = 30;
  break;
  case 'Mon': $points_possible = 35;
  break;
}

$challenge_percent = ($points_possible / 34) * 100;

 ?>

 <?php $total = 0; ?>
 <?php $this_week = 0; ?>

@foreach($posts as $post)

<?php
  /**
   * Sum up the users points.
   */
  if ($post->created_at > $week_start_date) {
      $this_week += $post->points;
  }

  $total += $post->points;
 ?>

@endforeach


<div class="container">


  <div class="hero">

    <div class="profile-picture-container">
      <div class="complete">Challenge</div>
      <div class="pace">You</div>
      <div id="myComplete" data-percent="{{$challenge_percent}}"></div>
      <div id="myPace" data-percent="{{(int) (($this_week / 34) * 100)}}"></div>
      <div class="p-profile-picture" style="background-image: url(/images/{{$user->profile_picture}})"></div>
    </div>

    <div class="stats">

      <div class="week-stats">
          <span class="stat-number">{{$this_week}}</span>
          <span class="stat-type">This week</span>
      </div>


      <div class="total-stats">
        <span class="stat-number">{{$post_sum}}</span>
        <span class="stat-type">Total</span>
      </div>


      <div class="complete-stats">
        <span class="stat-number">
           {{(int) (($this_week / 34) * 100)}}%
        </span>
        <span class="stat-type">Complete</span>
      </div>
    </div>

  </div>

  <div class="activity-breaker">
    Activity
  </div>


<div class="infinite-scroll">
@foreach($posts as $post)
  <?php
    /**
     *Find the User associated with the post.
     */
    $user = App\User::find($post->user_id);
    $team = App\Teams::find($user->teams_id);
   ?>

  <div class="post">
    <div class="user_info">
      <div class="profile-picture" style="background-image: url(/images/{{$user->profile_picture}})"></div>
      <div class="name-and-team">
        <span class="name">{{$user->name}}
          @if($user->team_leader == 1)
          <div class="team-leader-indicator"></div>
          @endif
        </span>
        @if($user->teams_id > 0)
        <span class="team">{{$team->team_name}}</span>
        @endif
      </div>
      <div class="time-ago">
        <time class="timeago" datetime="{{$post->updated_at}}"></time>
      </div>
    </div>

    @if(strlen($post->journal_nutrition) > 0)
      <div class="post-body">
        <div class="post-label">Nutrition</div>
        <span class="more">{!! nl2br(e($post->journal_nutrition)) !!}</span>
      </div>
    @endif
    @if(strlen($post->journal_exercise) > 0)
      <div class="post-body">
        <div class="post-label">Exercise</div>
        <span class="more">{!! nl2br(e($post->journal_exercise)) !!}</span>
      </div>
    @endif
    @if(strlen($post->journal_bible_study) > 0)
      <div class="post-body">
        <div class="post-label">Bible Study</div>
        <span class="more">{!! nl2br(e($post->journal_bible_study)) !!}</span>
      </div>
    @endif

    <div class="post-date">
      <!-- Date Posted -->
      {{App\Post::formatDateForPost($post->submit_date)}}
    </div>
    <div class="achievements-comments-container">
      <div class="achievements">

        <!-- Sugar -->
        @if($post->sugar == 1)
          <div class="sugar achieved"></div>
        @else
          <div class="sugar"></div>
        @endif

        <!-- Grain -->
        @if($post->grain == 1)
          <div class="grain achieved"></div>
        @else
          <div class="grain"></div>
        @endif

        <!-- Water -->
        @if($post->water == 1)
          <div class="water achieved"></div>
        @else
          <div class="water"></div>
        @endif

        <!-- Workout -->
        @if($post->workout == 1)
          <div class="workout achieved"></div>
        @else
          <div class="workout"></div>
        @endif

        <!-- bible_study -->
        @if($post->bible_study == 1)
          <div class="bible_study achieved"></div>
        @else
          <div class="bible_study"></div>
        @endif


      </div>

      <!-- Comment link -->
      <span class="comment">
        <a href="/comments/{{$post->id}}">
        @if($post->comments->count() > 1)
        VIEW {{$post->comments->count()}} COMMENTS
        @elseif($post->comments->count() > 0)
        VIEW {{$post->comments->count()}} COMMENT
        @else
        ADD COMMENT
        @endif
         <div class="icon-bubble" style="display: inline-block; transform: scale(1.5); margin-left: 10px;"></div>
       </a>
      </span>

    </div>

  </div><!-- End post -->

@endforeach

{{$posts->links()}}
</div>

</div> <!-- End container -->

@endsection
