@extends('layouts.app')

@section('content')

<div class="header">
  <div class="title">
    Calendar
  </div>
  <div class="settings-icon-container">
    <div class="icon-settings"></div>
  </div>
</div>

<div class="container">
<div class="day-of-week-breaker"></div>
<div class="days-of-week">
  <div class="day-container">
    <div class="day">
      sun
    </div>
  </div>
  <div class="day-container">
    <div class="day">
      mon
    </div>
  </div>
  <div class="day-container">
    <div class="day">
      tue
    </div>
  </div>
  <div class="day-container">
    <div class="day">
      wed
    </div>
  </div>
  <div class="day-container">
    <div class="day">
      thu
    </div>
  </div>
  <div class="day-container">
    <div class="day">
      fri
    </div>
  </div>
  <div class="day-container">
    <div class="day">
      sat
    </div>
  </div>
</div>


<?php
 // Gets todays date
 $today_date = Carbon\Carbon::today()->format('n-d-Y');

 // Get the current month
 $current_month_number = Carbon\Carbon::today()->format('n');

 // get users id
 $user_id = Auth::user()->id;

 // set the first day of the first month
 // in 2017 the first day of the year
 // was on sunday, so it is 0.
 // This gets reset at the end of
 // every month to start the next month.
 $first_day_of_month = 0;

 // array to hold the number of days for each month
 $number_of_days = array();
 $number_of_days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

 // used to increment throught the calendar for each month.
 $day = 1;
 $x = 0;
 // Array of month titles
 $month = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

 ?>

 @for ($i = 0; $i < sizeof($month); ++$i)
 <?php  $month_num = $i + 1; ?>
    @if($month_num == $current_month_number)
      <div class="month current-month">
    @else
      <div class="month">
    @endif
      <div class="month-title">{{$month[$i]}}</div>
    </div>

     @for ($j = 0; $j < 6; ++$j)
        <div class="week-container">
         @for ($z = 0; $z < 7; ++$z)
          <div class="day-container">
             @if ($x >= $first_day_of_month && $day <= $number_of_days[$i])
             <?php
             $day_num = $day;
             if ($day < 10 && $day > 0) {
                 $day_num = '0'.$day;
             }
             $today_check = $month_num.'-'.$day_num.'-2017';
              ?>
                @if($today_check == $today_date)
                   <div class="date today">
                      {{$day}}
                   </div>
                 @else
                   <div class="date">
                      {{$day}}
                   </div>


                   @if(in_array($today_check, $dates_posted))
                   <div class="date-indicator">
                   </div>
                   @endif

                 @endif

                 @if ($day == $number_of_days[$i])
                     <?php $first_day_of_month = ($z + 1) % 7; ?>
                 @endif
                 <?php ++$day; ?>
             @endif
             <?php ++$x; ?>

           </div>
         @endfor
      </div>
     @endfor
    <?php $day = 1; ?>
     <?php $x = 0; ?>
 @endfor

</div>

@endsection
