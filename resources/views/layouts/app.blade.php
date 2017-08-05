<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>


    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="7WM">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' name='viewport' />


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>7WM</title>

    <!-- Icon -->
    <link rel="icon" href="/assets/profile.jpg" type="image/x-icon" />
    <link rel="apple-touch-icon" href="/assets/profile.jpg">
    <link rel="manifest" href="/assets/manifest.json">

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">



    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/team.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/add-post.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/comments.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/calendar.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('css/message-modal.css?v=1.2') }}" rel="stylesheet">

    <!-- CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <!-- CND for circliful -->
    <script src="https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js"></script>


    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>


</head>
<body>

  @yield('content')

  @if(!Auth::guest())
    <nav class="menu">

      <!-- home -->
      <div class="menu_item">
        <a href="/home">
        <div class="menu-icon icon-home">
        </div>
        </a>
      </div>

      <!-- Teams -->
      @if(Auth::user()->teams_id <= 40)
      <div class="leaderboard-modal-menu">
        <!-- <a href="/teams"> -->
          <div class="menu-icon icon-badge">
          </div>
        <!-- </a> -->
      </div>
      @else
      <div class="leaderboard-modal-menu">
        <!-- <a href="/teams2k2"> -->
          <div class="menu-icon icon-badge">
          </div>
        <!-- </a> -->
      </div>
      @endif

      <!-- insert -->
      <div class="insert">
        <div class="menu-icon-plus icon-plus">
        </div>
      </div>
      <!-- calendar -->
      <div class="menu_item">
        <a href="/calendar">
          <div class="menu-icon icon-calendar">
          </div>
        </a>
      </div>
      <!-- profile -->
      <div class="menu_item">
        <a href="/profile/{{Auth::user()->id}}">
          <div class="menu-icon icon-user">
          </div>
        </a>
      </div>
    </nav>
  @endif




  <!-- settings modal -->

  <div class="settings">
    <div class="icon-close"></div>
    <div class="settings-menu">


      <form action="/add_profile_picture" id="file" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <label class="settings-menu-item" for="profile-picture">change profile pic</label>
        <input id="profile-picture" class="settings-menu-item " type="file" name="image" style="display: none;" onchange="this.form.submit();"><br>
      </form>

      <div class="settings-menu-item "><a href="/add_family_member">add family member</a></div>


      <a href="{{ url('/logout') }}" id="logout-fix">
        <div class="settings-menu-item logout">logout</div>
      </a>
      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
    </div>

  </div>

  <?php


    // Creates array to hold todays achievments
    $today = array();
    $today['sugar'] = '0';
    $today['grain'] = '0';
    $today['water'] = '0';
    $today['workout'] = '0';
    $today['bible_study'] = '0';

    // Creates array to hold yesterdays achievments
    $yesterday = array();
    $yesterday['sugar'] = '0';
    $yesterday['grain'] = '0';
    $yesterday['water'] = '0';
    $yesterday['workout'] = '0';
    $yesterday['bible_study'] = '0';

    // Get todays, and yesterdays dates
    // needed today abd ompare to compare
    // this date against another in post model
    $today_date = Carbon\Carbon::today()->format('n-d-Y');
    $today_date_compare = Carbon\Carbon::today();
    $yesterday_date = Carbon\Carbon::yesterday()->format('n-d-Y');
    $yesterday_date_compare = Carbon\Carbon::yesterday();

    // If each achievment has been previously selected
    // for that day, set it inside an array with the value
    // of 1
    if (App\Post::checkSugar($today_date)) {
        $today['sugar'] = '1';
    }
    if (App\Post::checkGrain($today_date)) {
        $today['grain'] = '1';
    }
    if (App\Post::checkWater($today_date)) {
        $today['water'] = '1';
    }
    if (App\Post::checkExercise($today_date) || App\Post::exerciseWeek($today_date_compare) >= 6) {
        $today['workout'] = '1';
    }

    if (App\Post::checkBibleStudy($today_date)) {
        $today['bible_study'] = '1';
    }

    if (App\Post::checkSugar($yesterday_date)) {
        $yesterday['sugar'] = '1';
    }
    if (App\Post::checkGrain($yesterday_date)) {
        $yesterday['grain'] = '1';
    }
    if (App\Post::checkWater($yesterday_date)) {
        $yesterday['water'] = '1';
    }
    if (App\Post::exerciseWeek($yesterday_date_compare) >= 6 || App\Post::checkExercise($yesterday_date)) {
        $yesterday['workout'] = '1';
    }

    if (App\Post::checkBibleStudy($yesterday_date)) {
        $yesterday['bible_study'] = '1';
    }

  ?>

  <!--  Add new post modal-->


  <div class="insert-modal">

    <!-- Mother's Day Message Modal -->
    @if(Auth::user()->message_seen == 0 || Auth::user()->message_seen == null)
    <div class="message-modal is_showing">
      <div class="icon-close"></div>

      <div class="message-and-logo-container">
        <div class="logo-add-post"></div>
        Ladies — Pastor Steven & Holly would like to bless you with two free points on Mother’s Day,
        even if you're not a mom! Go ahead and log your sugar and grain points on Sunday but indulge
        in whatever you like to celebrate and make sure to thank them in your journal entry. And
        fellas enjoy some treats on Father’s Day.
       <div class="happy-mothers-day">Happy Mother's Day!</div>
       <div class="center-button">
         <button id="close-message-button" class="close-message-button">Ok</button>
       </div>
      </div>
    </div>
    @endif

    <!--  -->
    <!--  -->
    <!--  -->

    <div class="icon-close"></div>

    <div class="logo-and-text-container">
      <div class="logo-add-post"></div>
      Select your completed activities for the day.
    </div>


    <form id="add-post" method="POST" action="/post">

        {{ csrf_field() }}

      <div class="insert-achievements">

        <div class="achievement-sugar">
          <div class="achievement" style="background-image: url('/assets/sugar.png');">
              <input id="sugar_check_box" name="sugar_check_box" type="checkbox" style="display: none"/>
          </div>
          No Sugar
        </div>


        <div class="achievement-grain">
          <div class="achievement" style="background-image: url('/assets/grain.png');">
            <input id="grain_check_box" name="grain_check_box" type="checkbox" style="display: none"/>
          </div>
          No Grain
        </div>

        <div class="achievement-water">
          <div class="achievement" style="background-image: url('/assets/water.png');">
            <input id="water_check_box" name="water_check_box" type="checkbox" style="display: none"/>
          </div>
          Water %
        </div>

        <div class="" style="display:flex; justify-content: center; width: 100%">
          <div class="achievement-exercise">
            <div class="achievement" style="background-image: url('/assets/workout.png'); margin: 0px 10px;">
              <input id="exercise_check_box" name="exercise_check_box" type="checkbox" style="display: none" />
            </div>
            Exercise
          </div>

          <div class="achievement-bible-study">
            <div class="achievement" style="background-image: url('/assets/bible.png'); margin: 0px 10px;">
              <input id="bible_study_check_box" name="bible_study_check_box" type="checkbox" style="display: none" />
            </div>
            Bible Study
          </div>
        </div>

      </div>

      <div class="continue-insert" style="color: white;">
        <div class="log-for-yesterday">
          <input id="log-for-yesterday" name="log_for_yesterday" type="checkbox" />
          Log for yesterday
        </div>

        <button class="continue-insert-button">Continue</button>
      </div>

      <div class="journal-entry">
        <div class="previous icon-arrow-left"></div>

        <div class="close-modal" style="color: white;">
          <div class="icon-close"></div>
        </div>


        <div class="journal-entry-container">
          <div class="journal-entry-icon-container">
            <div class="sugar-small"></div>
            <div class="grain-small"></div>
            <div class="water-small"></div>
            <div class="exercise-small"></div>
            <div class="bible-study-small"></div>
          </div>
          <div class="journal-description">
            <label>
              <!--  -->
            </label>
          </div>

          <?php

            // Initialize the arrays
            $today_post = array();
            $yesterday_post = array();

            // If the user has already posted fot that day
            // fill the array with the values from each
            // journal entry for today.
            if (App\Post::alreadyPosted($today_date)) {
                $today_post = array(
                'journal_nutrition' => App\Post::getPostFromDate($today_date)->journal_nutrition,
                'journal_exercise' => App\Post::getPostFromDate($today_date)->journal_exercise,
                'journal_bible_study' => App\Post::getPostFromDate($today_date)->journal_bible_study,
              );
            }

            // If the user has already posted fot that day
            // fill the array with the values from each
            // journal entry for yesterday.
            if (App\Post::alreadyPosted($yesterday_date)) {
                $yesterday_post = array(
                'journal_nutrition' => App\Post::getPostFromDate($yesterday_date)->journal_nutrition,
                'journal_exercise' => App\Post::getPostFromDate($yesterday_date)->journal_exercise,
                'journal_bible_study' => App\Post::getPostFromDate($yesterday_date)->journal_bible_study,
              );
            }
           ?>



          <div class="journal-nutrition">
            <label class="journal-type">Nutrition</label>
            <textarea class="journal-entry-input journal-nutrition-input" name="journal_nutrition" id="journal_nutrition"></textarea>
          </div>

          <div class="journal-exercise">
            <label class="journal-type">Exercise</label>
            <textarea class="journal-entry-input journal-exercise-input" name="journal_exercise" id="journal_exercise"></textarea>
          </div>

          <div class="journal-bible">
            <label class="journal-type">Bible Study</label>
            <textarea class="journal-entry-input journal-bible-input" name="journal_bible" id="journal_bible_study"></textarea>
          </div>


          <!--  if the user hasnt submitted a shirt size -->
          @if(Auth::user()->shirt_size == NULL)
            <button class="go-to-shirt-size">NEXT</button>
          @else
            <!-- else submit their journal entries -->
            <button class="submit-journal" type="submit">FINISH</button>
          @endif
        </div>

      </div>



      <!--  t shirt size -->
      <div class="insert-shirt-size">

        <div class="icon-close"></div>

        <div class="logo-and-text-container">
          <div class="logo-add-post"></div>
          Choose a tank top size if you plan to earn 200 points.
        </div>

        <div class="size-container">
        <div class="size-xsmall">
          <div class="size">
              <input id="xsmall_check_box" name="xsmall_check_box" type="checkbox" style="display: none;"/>
              XS
          </div>
        </div>


        <div class="size-small">
          <div class="size">
              <input id="small_check_box" name="small_check_box" type="checkbox" style="display: none;"/>
              S
          </div>
        </div>

        <div class="size-medium">
          <div class="size">
              <input id="medium_check_box" name="medium_check_box" type="checkbox" style="display: none;"/>
              M
          </div>
        </div>

          <div class="size-large">
            <div class="size">
                <input id="large_check_box" name="large_check_box" type="checkbox" style="display: none;"/>
                L
            </div>
          </div>

          <div class="size-xlarge">
            <div class="size">
                <input id="xlarge_check_box" name="xlarge_check_box" type="checkbox" style="display: none;"/>
                XL
            </div>
          </div>

          <div class="size-xxlarge">
            <div class="size">
                <input id="xxlarge_check_box" name="xxlarge_check_box" type="checkbox" style="display: none;"/>
                XXL
            </div>
          </div>

        </div>


        <div class="continue-insert" style="color: white;">
          <div class="log-for-yesterday">
            <input id="no-shirt-wanted" name="no_shirt_wanted" type="checkbox" />
            No shirt earned
          </div>

          <button class="submit-journal" type="submit">FINISH</button>
        </div>

      </div>






    </form>
  </div>



<!-- Scripts -->
<script type="text/javascript">
// set php arrays to JS arrays
var today = {!! json_encode($today) !!}
var yesterday = {!! json_encode($yesterday) !!}
var today_post = {!! json_encode($today_post) !!}
var yesterday_post = {!! json_encode($yesterday_post) !!}
</script>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/functions.js?v=1') }}" type="text/javascript"></script>
<script src="{{ asset('js/add_post.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.jscroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.timeago.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/calendar.js') }}" type="text/javascript"></script>

<!-- CND for circliful -->
<script src="https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js"></script>

</body>
</html>
