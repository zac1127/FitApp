@extends('layouts.app')

@section('content')


<div class="header">
  <a href="{{URL::previous()}}"><div class="back icon-arrow-left"></div></a>
  <div class="title">
    Team
  </div>
  <div class="settings-icon-container">
    <div class="icon-settings"></div>
  </div>
</div>

<div class="container">
  @foreach($members as $member)
  <a href="/profile/{{$member->id}}">
  <div class="team-container">
    <div class="team-placement">
      <div class="team-profile-picture" style="background-image: url(/images/{{$member->profile_picture}})"></div>
    </div>
    <div class="team-details">
      <span class="team-name">
        {{$member->name}}
      </span>

      <?php $total = 0;

      $posts = App\Post::where('user_id', $member->id)->get();
      ?>
      @foreach($posts as $post)
      <?php
        /**
         * Sum up the users points.
         */
        $total += $post->points;

      ?>

      @endforeach
      <span class="team-points">{{$total}} Points</span>

    </div>

  </div>

  </a>
  @endforeach


</div>

@endsection
