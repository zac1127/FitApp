@extends('layouts.app')

@section('content')


<div class="header">
      <div class="header-logo"></div>
      <div class="settings-icon-container">
        <div class="icon-settings"></div>
      </div>
</div>



<div class="container">

  <?php
    $week_num = App\Week::all()->count();
   ?>

  <div class="numbers">
    @if($week_num > 3)
    <div class="number-container">
      <div class="number f-fade">{{$week_num - 3}}</div>
    </div>
    @else
    <div class="number-container">
      <div class="number"></div>
    </div>
    @endif
    @if($week_num > 2)
    <div class="number-container">
      <div class="number m-fade">{{$week_num - 2}}</div>
    </div>
    @else
    <div class="number-container">
      <div class="number"></div>
    </div>
    @endif
    @if($week_num > 1)
    <div class="number-container">
      <div class="number">{{$week_num - 1}}</div>
    </div>
    @else
    <div class="number-container">
      <div class="number"></div>
    </div>
    @endif
    <div class="number-container seven">
      <div class="number">{{$week_num}}</div>
    </div>
    <div class="number-container">
      <div class="number">{{$week_num + 1}}</div>
    </div>

    <div class="number-container">
      <div class="number m-fade">{{$week_num + 2}}</div>
    </div>

    <div class="number-container">
      <div class="number f-fade">{{$week_num + 3}}</div>
    </div>


  </div>



<div class="infinite-scroll">
@foreach($posts as $post)

  <?php

    /**
     *Find the User associated with the post.
     */
    $user = App\User::find($post->user_id);
    $team = App\Teams::find($user->teams_id);


    if(file_exists("./images/$user->profile_picture")) {
        $profile_picture = "./images/" . $user->profile_picture;
    } else {
        $profile_picture = "./images/profile.jpg";
    }

   ?>

  <div class="post">
    <div class="user_info">
      <a href="/profile/{{$user->id}}">
        <div class="profile-picture" style="background-image: url({{$profile_picture}})"></div>
      </a>
      <div class="name-and-team">
        <span class="name"><a href="/profile/{{$user->id}}">{{ $user->name }}</a>
          @if($user->team_leader == 1)
          <div class="team-leader-indicator"></div>
          @endif
        </span>
        @if($user->teams_id > 0)
        <span class="team">{{$team->team_name}}</span>
        @endif      </div>
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
        @elseif($post->comments->count() == 1)
         VIEW {{$post->comments->count()}} COMMENT
        @else
         ADD COMMENT
        @endif
         <div class="icon-bubble" style="display: inline-block; transform: scale(1.5); margin-left: 10px;"></div>
       </a>
      </span>

    </div>

  </div>

@endforeach
{{$posts->links()}}
</div>

</div>
@endsection
