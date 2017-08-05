@extends('layouts.app')

@section('content')


<div class="header">
  <div class="title">
    Teams
  </div>
  <div class="settings-icon-container">
    <div class="icon-settings"></div>
  </div>
</div>



<div class="container">

  <div class="team-type-container">
    @if(Route::current()->uri == 'teams2k2')
    <div class="team-staff active"> <a href="/teams">Staff</a></div>
    <div class="team-2k2">2k2</div>
    @else
    <div class="team-staff">Staff</div>
    <div class="team-2k2 active"> <a href="/teams2k2">2k2</a></div>
    @endif
  </div>

<?php $i = 1; ?>
@foreach($teams as $team)
<a href="/team/{{$team->id}}">
<div class="team-container">
  <div class="team-placement">
    <span class="place-number">{{$i}}</span>
  </div>
  <div class="team-details">
    <span class="team-name">{{$team->team_name}}</span>
      <span class="team-points">Avg: {{$team->avg}} points</span>
  </div>
  <div class="team-arrow">
    <div class="icon-arrow-right"></div>
  </div>

</div>
</a>

<?php ++$i; ?>

@endforeach


</div>

@endsection
