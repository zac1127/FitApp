<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Points</title>
    <link href="{{ asset('css/shirts.css?v=1.0') }}" rel="stylesheet">

  </head>
  <body>

    <div class="title">
      7WM User's Points
    </div>


    <div class="title-row">
    <h1>Staff Team</h1>
    <div class="name">Name</div>
    <div class="size">Points</div>
    </div>
    <div class="container">
      @foreach($staff_teams as $team)
      <div class="row">
      <div class="name">{{$team->team_name}}</div>
      <div class="size">{{$team->avg}}</div>
      </div>
      @endforeach
    </div>

    <div class="title-row">
    <h1>Staff Individual</h1>
    <div class="name">Name</div>
    <div class="size">Points</div>
    </div>
    <div class="container">
      @foreach($users_staff as $user)
      <div class="row">
      <div class="name">{{$user->name}}</div>
      <div class="size">{{$user->points}}</div>
      </div>
      @endforeach
    </div>


    <div class="title-row">
    <h1>2k2 Team</h1>
    <div class="name">Name</div>
    <div class="size">Points</div>
    </div>
    <div class="container">
      @foreach($contract_teams as $team)
      <div class="row">
      <div class="name">{{$team->team_name}}</div>
      <div class="size">{{$team->avg}}</div>
      </div>
      @endforeach
    </div>

    <div class="title-row">
    <h1>2k2 Individual</h1>
    <div class="name">Name</div>
    <div class="size">Points</div>
    </div>
    <div class="container">
      @foreach($users_contract as $user)
      <div class="row">
      <div class="name">{{$user->name}}</div>
      <div class="size">{{$user->points}}</div>
      </div>
      @endforeach
    </div>



  </body>
</html>
