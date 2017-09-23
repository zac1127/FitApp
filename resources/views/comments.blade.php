@extends('layouts.app')

@section('content')


<div class="header">
  <div class="back icon-arrow-left"></div>

    <div class="title">
    Comments
  </div>
  <div class="settings-icon-container">
    <div class="icon-settings"></div>
  </div>
</div>


<div class="container">
  <?php
    /**
     *Find the User associated with the post.
     */
    $user = App\User::find($post->user_id);
    $team = App\Teams::find($user->teams_id);

    if(file_exists("./images/$user->profile_picture")) {
        $profile_picture = "/images/" . $user->profile_picture;
    } else {
        $profile_picture = "/images/profile.jpg";
    }
   ?>

  <div class="post" style="margin: -10px auto 0px;">
    <div class="user_info">
      <div class="profile-picture" style="background-image: url({{$profile_picture}})"></div>
      <div class="name-and-team">
        <span class="name"><a href="/profile/{{$user->id}}">{{ $user->name }}
          @if($user->team_leader == 1)
          <div class="team-leader-indicator"></div>
          @endif
        </a></span>
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

    </div>

  </div> <!-- end post -->

  @foreach($comments as $comment)

  <?php
    /**
     * Get the user who belongs to the comment
     * and the obtain their profile picture.
     */
    $user_id = $comment->user_id;
    $user = App\User::where('id', $user_id)->get()[0];
    $profile_picture = $user->profile_picture;
   ?>

   <div class="user-comment">

    <div class="comment-pic-container">
      <a href="/profile/{{$user_id}}">
        <div class="comment-pic" style="background-image: url('/images/{{$profile_picture}}')">
        </div>
      </a>
    </div>
    <div class="comment-details">
      <a href="/profile/{{$user_id}}">
        <div class="comment-name">
          {{$user->name}}
        </div>
      </a>
      <div class="comment-time-ago">
        <time class="timeago" datetime="{{$comment->created_at}}"></time>
      </div>
      <div class="comment-body">
        {{$comment->comment}}
      </div>

    </div>
  </div>

  @endforeach

  <!-- Div below appends ajax request posts -->
  <div class="new-user-comment"></div>


  <div class="add-comment">
  <form id="comment-form" action="/add_comment" method="post" >
    {{ csrf_field() }}
    <input type="hidden" name="post_id" value="{{$post->id}}">

    <div class="comment-input-container">
      <input id="comment-input" type="text" name="comment" align="bottom" placeholder="Add a comment" required>
    </div>

    <div class="comment-send">
      <button class="send-button">
        <div class="icon-plus"></div>
      </button>
    </div>
  </form>
  </div>

</div><!-- end container -->
<script> var host = "{{URL::to('/')}}"; </script>

@endsection
