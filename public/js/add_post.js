$(document).ready(function() {

  checkSizes();
  closeMessage();

  /**
  * Logo check box check
  */

  var day = today;
  currentDay(day);
  // prevents the form from being submit twice
  stopMultipleSubmissions();



  $('#log-for-yesterday').change(function() {

      /**
      * check box is either checked or not
      */
      if(this.checked) {
        day = yesterday;
      } else {
        day = today;
      }

      resetIcons();

      currentDay(day);


    }); // end on click


    /**
    *Sugar
    */

      $('.achievement-sugar').on('click', function() {
        if(!$('.achievement-sugar').hasClass('logged')){
          sugar_icon();
        }
      });

    /**
    *grain
    */
      $('.achievement-grain').on('click', function() {
        if(!$('.achievement-grain').hasClass('logged')){
          grain_icon();
        }
      });

    /**
    *water
    */

      $('.achievement-water').on('click', function() {
        if(!$('.achievement-water').hasClass('logged')){
          water_icon();
        }
      });

    /**
    *excercise
    */
      $('.achievement-exercise').on('click', function() {
        if(!$('.achievement-exercise').hasClass('logged')){
          workout_icon();
        }
      });


    /**
    *bible study
    */
      $('.achievement-bible-study').on('click', function() {
        if(!$('.achievement-bible-study').hasClass('logged')){
          bible_study_icon();
        }
      });


  /**
  * moves to next screen
  */
$('.continue-insert-button').on('click', function() {
  event.preventDefault();
  /**
  * If the checkbox is checked, the textboxs on the
  * next modal will be filled with the values
  * from a previous post @ via the arrays
  */
  if($('#log-for-yesterday').prop('checked')){
    $('#journal_nutrition').val(yesterday_post['journal_nutrition']);
    $('#journal_exercise').val(yesterday_post['journal_exercise']);
    $('#journal_bible_study').val(yesterday_post['journal_bible_study']);
  } else {
    $('#journal_nutrition').val(today_post['journal_nutrition']);
    $('#journal_exercise').val(today_post['journal_exercise']);
    $('#journal_bible_study').val(today_post['journal_bible_study']);
  }

  /**
  * If the continue button is active, and clicked,
  * add the is_showing class to the next modal.
  */
  if($('.continue-insert-button').hasClass('active')){
    setTimeout(function() {
      $('.journal-entry').addClass('is_showing');
    }, 100);
  }
});



$('.go-to-shirt-size').on('click', function() {
  event.preventDefault();

  if($('.go-to-shirt-size').hasClass('is_showing')){
    setTimeout(function() {
      $('.insert-shirt-size').addClass('is_showing');
    }, 100);
  }
});

  /**
  * Disable the submit button
  */
  $('.submit-journal').attr('disabled', true);

  /**
  * When user types check and make sure the text
  * box has a value and add class to submit
  */

  $('.journal-entry-input').on('keyup',function() {

      var d = new Date();
      var hour = d.getHours();

      console.log(hour);

       if(hour >= 0 && hour < 4) {
           $('.submit-journal').prop('disabled', true);
           $('.submit-journal').attr('disabled' , true);
           $('.submit-journal').removeClass('is_showing');
           return;
       }

        if(acitvateButton()) {
            $('.submit-journal').attr('disabled' , false);
            $('.submit-journal').addClass('is_showing');
            $('.go-to-shirt-size').addClass('is_showing');
        } else {
            $('.submit-journal').attr('disabled' , true);
            $('.submit-journal').removeClass('is_showing');
            $('.go-to-shirt-size').removeClass('is_showing');
        }

  });

  // disable posts after 12am-4am
  disableButtonAfterMidnight();

});

function disableButtonAfterMidnight() {
    var d = new Date();
    var hour = d.getHours();

    console.log(hour);

    if(hour > 20 && hour < 24)
     {
         $('.submit-journal').prop('disabled', true);
     }
}

function stopMultipleSubmissions() {
    $('#add-post').on('submit', function(){
      if(!$('.submit-journal').is(':disabled')) {
        $('.submit-journal').prop('disabled', true);
        $('#add-post').submit();
      }
    });
}


function closeMessage() {
  $('#close-message-button').on('click', function(){
    $('.message-modal').removeClass('is_showing');
  });
}

function checkSizes(){
  $('.size-xsmall').on('click', function(){
    if(!$('#no-shirt-wanted').is(":checked")){
      clearSizes();
      if($('#xsmall_check_box').is(":checked")){
        $('#xsmall_check_box').attr('checked', false);
        $('.size-xsmall').removeClass('active');
      } else {
        $('#xsmall_check_box').attr('checked', true);
        $('.size-xsmall').addClass('active');
      }
    }
  });

  $('.size-small').on('click', function(){
    if(!$('#no-shirt-wanted').is(":checked")){
      clearSizes();
      if($('#small_check_box').is(":checked")){
        $('#small_check_box').attr('checked', false);
        $('.size-small').removeClass('active');
      } else {
        $('#small_check_box').attr('checked', true);
        $('.size-small').addClass('active');
      }
    }
  });

  $('.size-medium').on('click', function(){
    if(!$('#no-shirt-wanted').is(":checked")){
      clearSizes();
      if($('#medium_check_box').is(":checked")){
        $('#medium_check_box').attr('checked', false);
        $('.size-medium').removeClass('active');
      } else {
        $('#medium_check_box').attr('checked', true);
        $('.size-medium').addClass('active');
      }
    }
  });

  $('.size-large').on('click', function(){
    if(!$('#no-shirt-wanted').is(":checked")){
      clearSizes();
      if($('#large_check_box').is(":checked")){
        $('#large_check_box').attr('checked', false);
        $('.size-large').removeClass('active');
      } else {
        $('#large_check_box').attr('checked', true);
        $('.size-large').addClass('active');
      }
    }
  });

  $('.size-xlarge').on('click', function(){
    if(!$('#no-shirt-wanted').is(":checked")){
      clearSizes();
      if($('#xlarge_check_box').is(":checked")){
        $('.size-xlarge').removeClass('active');
        $('#xlarge_check_box').attr('checked', false);
      } else {
        $('#xlarge_check_box').attr('checked', true);
        $('.size-xlarge').addClass('active');
      }
    }
  });

  $('.size-xxlarge').on('click', function(){
    if(!$('#no-shirt-wanted').is(":checked")){
      clearSizes();
      if($('#xxlarge_check_box').is(":checked")){
        $('.size-xxlarge').removeClass('active');
        $('#xxlarge_check_box').attr('checked', false);
      } else {
        $('.size-xxlarge').addClass('active');
        $('#xxlarge_check_box').attr('checked', true);
      }
    }
  });

  $('#no-shirt-wanted').on('click', function() {
    if($('#no-shirt-wanted').is(":checked")){
      clearSizes();
    }
  })
}

function clearSizes() {
  $('#xsmall_check_box').attr('checked', false);
  $('#small_check_box').attr('checked', false);
  $('#medium_check_box').attr('checked', false);
  $('#large_check_box').attr('checked', false);
  $('#xlarge_check_box').attr('checked', false);
  $('#xxlarge_check_box').attr('checked', false);

  $('.size-xsmall').removeClass('active');
  $('.size-small').removeClass('active');
  $('.size-medium').removeClass('active');
  $('.size-large').removeClass('active');
  $('.size-xlarge').removeClass('active');
  $('.size-xxlarge').removeClass('active');
}


  function acitvateButton() {
    var activateButton = true;

    var bible_study = $('.bible-study-small').hasClass('is_showing');
    var bible_value = $(".journal-bible-input").val().trim();


    var excercise = $('.exercise-small').hasClass('is_showing');
    var exercise_value = $(".journal-exercise-input").val().trim();

    var nutrition = nutritionSelected();
    var nutrition_value = $(".journal-nutrition-input").val().trim();


    if(bible_study && !excercise && !nutrition){
      if(bible_value.length > 0) {
        activateButton = true;
      } else {
        activateButton = false;
      }
    }

    if(!bible_study && excercise && !nutrition){
      if(exercise_value.length > 0) {
        activateButton = true;
      } else {
        activateButton = false;
      }
    }

    if(!bible_study && !excercise && nutrition){
      if(nutrition_value.length > 0) {
        activateButton = true;
      } else {
        activateButton = false;
      }
    }

    if(bible_study && !excercise && nutrition){
      if(bible_value.length > 0 && nutrition_value.length > 0) {
        console.log('this onw');
        activateButton = true;
      } else {
        activateButton = false;
      }
    }

    if(bible_study && excercise && !nutrition){
      if(bible_value.length > 0 && exercise_value.length > 0) {
        activateButton = true;
      } else {
        activateButton = false;
      }
    }
    if(!bible_study && excercise && nutrition){
      if(exercise_value.length > 0 && nutrition_value.length > 0) {
        activateButton = true;
      } else {
        activateButton = false;
      }
    }

    if(bible_study && excercise && nutrition){
      if(bible_value.length > 0 && exercise_value.length > 0 && nutrition_value.length > 0) {
        activateButton = true;
      } else {
        activateButton = false;
      }
    }

    return activateButton;

  }


  function currentDay(day) {

    if(day['sugar'] == 1){
      $('.achievement-sugar').addClass('logged');
    }

    if(day['grain'] == 1){
      $('.achievement-grain').addClass('logged');
    }

    if(day['water'] == 1){
      $('.achievement-water').addClass('logged');
    }

    if(day['workout'] == 1){
      $('.achievement-exercise').addClass('logged');
    }

    if(day['bible_study'] == 1){
      $('.achievement-bible-study').addClass('logged');
    }

  }


  function resetIcons() {
    /**
    * Remove all highlighted icons
    */
    $('.achievement-sugar').removeClass('is_showing');
    $('.achievement-water').removeClass('is_showing');
    $('.achievement-grain').removeClass('is_showing');
    $('.achievement-exercise').removeClass('is_showing');
    $('.achievement-bible-study').removeClass('is_showing');

    $('.sugar-small').removeClass('is_showing');
    $('.water-small').removeClass('is_showing');
    $('.grain-small').removeClass('is_showing');
    $('.exercise-small').removeClass('is_showing');
    $('.bible-study-small').removeClass('is_showing');


    $('.journal-nutrition').removeClass('is_showing');
    $('.journal-exercise').removeClass('is_showing');
    $('.journal-bible').removeClass('is_showing');


    $('#exercise_check_box').attr('checked', false);
    $('#water_check_box').attr('checked', false);
    $('#grain_check_box').attr('checked', false);
    $('#sugar_check_box').attr('checked', false);
    $('#bible_study_check_box').attr('checked', false);

    /**
    * remove all dimmed icons
    */
    $('.achievement-sugar').removeClass('logged');
    $('.achievement-water').removeClass('logged');
    $('.achievement-grain').removeClass('logged');
    $('.achievement-exercise').removeClass('logged');
    $('.achievement-bible-study').removeClass('logged');

    /**
    *n Deavticate the continue button
    */
    if(selected()){
      $('.continue-insert-button').addClass('active');
    } else {
      $('.continue-insert-button').removeClass('active');
    }

  }


  function sugar_icon() {

    /**
    * This toggles the check box when image is clicked
    */
    if($('#sugar_check_box').is(":checked")){
      $('#sugar_check_box').attr('checked', false);
    } else {
      $('#sugar_check_box').attr('checked', true);
    }
    /**
    * makes the icons for that achiement light up
    */
      $('.achievement-sugar').toggleClass('is_showing');
      $('.sugar-small').toggleClass('is_showing');

    /**
    * If the icons are lit up, show the text box and make the input required
    */
    if(nutritionSelected()){
      $('.journal-nutrition').addClass('is_showing');

    } else {
      $('.journal-nutrition').removeClass('is_showing');
      $("#journal-nutrition-input").val('');
    }
    /**
    *  If any icons are selected, add or remove the button color.
    */
    if(selected()){
      $('.continue-insert-button').addClass('active');
    } else {
      $('.continue-insert-button').removeClass('active');
    }
  }


  function grain_icon() {
    /**
    * This toggles the check box when image is clicked
    */
    if($('#grain_check_box').is(":checked")){
      $('#grain_check_box').attr('checked', false);
    } else {
      $('#grain_check_box').attr('checked', true);
    }
    /**
    * makes the icons for that achiement light up
    */
    $('.achievement-grain').toggleClass('is_showing');
    $('.grain-small').toggleClass('is_showing');
    /**
    * if they icons are lit up, show the text box and make the input required
    */
    if(nutritionSelected()){
      $('.journal-nutrition').addClass('is_showing');
    } else {
      $('.journal-nutrition').removeClass('is_showing');
      $(".journal-nutrition-input").val('');
    }
    /**
    *  If any icons are selected, add or remove the button color.
    */
    if(selected()){
      $('.continue-insert-button').addClass('active');
    } else {
      $('.continue-insert-button').removeClass('active');
    }
  }


  function water_icon(){
      /**
      * This toggles the check box when image is clicked
      */
      if($('#water_check_box').is(":checked")){
        $('#water_check_box').attr('checked', false);
      } else {
        $('#water_check_box').attr('checked', true);
      }
      /**
      * makes the icons for that achiement light up
      */
      $('.achievement-water').toggleClass('is_showing');
      $('.water-small').toggleClass('is_showing');
      /**
      * if they icons are lit up, show the text box and make the input required
      */

      if(nutritionSelected()){
        if(!$('.journal-nutrition').hasClass('is_showing')) {
          $('.journal-nutrition').addClass('is_showing');
        }
      } else {
        $('.journal-nutrition').removeClass('is_showing');
        $(".journal-nutrition-input").val('');
      }
      /**
      *  If any icons are selected, add or remove the button color.
      */
      if(selected()){
        $('.continue-insert-button').addClass('active');

      } else {
        $('.continue-insert-button').removeClass('active');
      }

  }



  function workout_icon() {
        /**
        * This toggles the check box when image is clicked
        */
        if($('#exercise_check_box').is(":checked")){
          $('#exercise_check_box').attr('checked', false);
        } else {
          $('#exercise_check_box').attr('checked', true);
        }
        /**
        * makes the icons for that achiement light up
        */
        $('.achievement-exercise').toggleClass('is_showing');
        $('.exercise-small').toggleClass('is_showing');
        /**
        * if they icons are lit up, show the text box and make the input required
        */

        if($('.exercise-small').hasClass('is_showing')){
          $('.journal-exercise').addClass('is_showing');
        } else {
          $('.journal-exercise').removeClass('is_showing');
          $(".journal-exercise-input").val('');
        }
        /**
        *  If any icons are selected, add or remove the button color.
        */

        if(selected()){
          $('.continue-insert-button').addClass('active');
        } else {
          $('.continue-insert-button').removeClass('active');
        }
  }



  function bible_study_icon(){
        /**
        * This toggles the check box when image is clicked
        */
        if($('#bible_study_check_box').is(":checked")){
          $('#bible_study_check_box').attr('checked', false);
        } else {
          $('#bible_study_check_box').attr('checked', true);
        }
        /**
        * makes the icons for that achiement light up
        */
        $('.achievement-bible-study').toggleClass('is_showing');
        $('.bible-study-small').toggleClass('is_showing');

        /**
        * if they icons are lit up, show the text box and make the input required
        */
        if($('.bible-study-small').hasClass('is_showing')){
          $('.journal-bible').addClass('is_showing');
        } else {
          $('.journal-bible').removeClass('is_showing');
          $(".journal-bible-input").val('');
        }
        /**
        *  If any icons are selected, add or remove the button color.
        */
        if(selected()){
          $('.continue-insert-button').addClass('active');
        } else {
          $('.continue-insert-button').removeClass('active');
        }

  }

  function selected() {
    var selected = false;
    if($('.achievement-exercise').hasClass('is_showing'))
    {
      selected = true;
    }

    if($('.achievement-water').hasClass('is_showing'))
    {
      selected = true;
    }

    if($('.achievement-sugar').hasClass('is_showing'))
    {
      selected = true;
    }

    if($('.achievement-grain').hasClass('is_showing'))
    {
      selected = true;
    }

    if($('.achievement-bible-study').hasClass('is_showing'))
    {
      selected = true;
    }

    return selected;

  }



  function nutritionSelected() {

    var selected = false;

    if($('.achievement-water').hasClass('is_showing'))
    {
      selected = true;
    }

    if($('.achievement-sugar').hasClass('is_showing'))
    {
      selected = true;
    }

    if($('.achievement-grain').hasClass('is_showing'))
    {
      selected = true;
    }

    return selected;

  }
