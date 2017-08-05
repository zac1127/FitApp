// show_more();

$(document).ready(function() {

  $('#comment-form').on('submit', function (e) {
        e.preventDefault();
        var comment = $('#comment-input').val();
        $.ajax({
            type: "POST",
            url: host + "/add_comment",
            data: $(this).serialize(),
            success: function( data ) {

              var myObj = JSON.parse(data);

              $('.new-user-comment').append(`
                <div class="user-comment">
                <div class="comment-pic-container">
                  <a href="/profile/`+myObj.user_id+`">
                    <div class="comment-pic" style="background-image: url('../images/`+myObj.profile_image+`')">
                    </div>
                  </a>
                </div>
                <div class="comment-details">
                  <a href="/profile/`+myObj.user_id+`">
                    <div class="comment-name">
                      `+myObj.user_name+`
                    </div>
                  </a>
                  <div class="comment-time-ago">
                     just now
                  </div>
                  <div class="comment-body">
                    `+myObj.comment+`
                  </div>
                  </div>
                `);

                $('#comment-input').val("");

            }

        });
    });



  $('.back').on('click', function() {
        window.history.back();
  });

  $(document).on('focusin', '#comment-input', function() {
    /**
    * when the comment box has focus
    */
    $('.add-comment').addClass('fix');
    $('.menu').hide();
    $(window).scrollTop($(document).height());


  })
  .on('focusout', '#comment-input', function () {
    /**
    * when the comment box loses focus
    */
    $('.add-comment').removeClass('fix');
    $('.menu').show();
  });


  $('.icon-settings').on('click', function() {
      $('.settings').addClass('is_showing');
  });


  /**
  * Progressive web app
  */
  $("a").click(function (event) {
    event.preventDefault();
    window.location = $(this).attr("href");
  });

  /**
  * Logout fix to work with Progressive Web App
  */

  $("#logout-fix").on('click', function() {
      event.preventDefault();
      document.getElementById('logout-form').submit();
  });

  /**
  * Time ago on post
  */

  $("time.timeago").timeago();


  /**
  * percentage circles around profile picture
  */
  percentage_circles();
  /**
  * Pagination
  */
  infinite_pagination();
  /**
  * New Journal enry modal
  */
  // add_post();

});



function percentage_circles() {
  /**
  * percentage circles around profile picture
  */

  $('#myPace').circliful({
      animationStep: 8,
      foregroundBorderWidth: 12,
      backgroundBorderWidth: 12,
      backgroundColor: "rgba(24,24,24,1)",
      foregroundColor: "#fff",
      replacePercentageByText: "",
      title: "Pace",
    });


    $('#myComplete').circliful({
        animationStep: 8,
        foregroundBorderWidth: 10,
        backgroundBorderWidth: 10,
        backgroundColor: "rgba(24,24,24,1)",
        foregroundColor: "rgba(253,100,70,1)",
        replacePercentageByText: "",
        title: "Complete",
    });

    /*
    * Animate in pace and complete
    */

    var complete = $('#myComplete').attr('data-percent');
    var pace = $('#myPace').attr('data-percent');


    setTimeout(function(){
      $('.complete').addClass('is_showing');
    }, 100);

    setTimeout(function(){
      $('.pace').addClass('is_showing');
    }, 300);

    if(complete > 90) {
      setTimeout(function(){
        $('.complete').removeClass('is_showing');
      }, 900);
    }

    if(pace > 90) {
      setTimeout(function(){
        $('.pace').removeClass('is_showing');
      }, 900);
    }
}

function infinite_pagination() {
  /**
  * Pagination
  */

    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            padding: 200,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                /* Add the show more button on large text */
                // show_more();
                /* removes laravels pagination links */
                $('ul.pagination').remove();
                /* Displays timeage on loaded posts */
                $("time.timeago").timeago();
                /**
                * Progressive web app
                */
                $("a").click(function (event) {
                  event.preventDefault();
                  window.location = $(this).attr("href");
                });

            }
        });
    });
}


function add_post() {
  /**
  * New Journal enry modal
  */

  $('.insert').on('click', function() {
    setTimeout(function() {
      $('.insert-modal').addClass('is_showing');
    }, 100);
  });

  $('.icon-close').on('click', function() {
    setTimeout(function() {
      $('.insert-modal').removeClass('is_showing');
      setTimeout(function(){
        $('.journal-entry').removeClass('is_showing');
      }, 200);
    }, 100);
    $('.settings').removeClass('is_showing');

  });


  /*
  * previous arrow when adding a new post
  */

  $('.previous').on('click', function() {
    /**
    * Moves to previous screen
    */
    $('.journal-entry').removeClass('is_showing');
    /**
    * Disables button and changes back to grey
    */
    $('.submit-journal').attr('disabled' , true);
    $('.submit-journal').removeClass('is_showing');
    /**
    * removes any text inputed in the text boxes
    */
    $(".journal-bible-input").val('');
    $(".journal-exercise-input").val('');
    $(".journal-nutrition-input").val('');

  });
}

function show_more() {
  /*
  * Show more button.
  */
  var showChar = 100;
  var moretext = "... more";
  var lesstext = "... less";

  $('.more').each(function() {
      var content = $(this).html();

      if(content.length > showChar+8) {
          var c = content.substr(0, showChar);
          var h = content.substr(showChar, content.length - showChar);
          var html = c + '<span class="morecontent"><span>' + h + '</span><div style="display: inline-block" class="morelink">' + moretext + '</div></span>';
          $(this).html(html);
      }
  });

  $(".morelink").click(function(){
    event.preventDefault();

      if($(this).hasClass("less")) {
          $(this).removeClass("less");
          $(this).html(moretext);
      } else {
          $(this).addClass("less");
          $(this).html(lesstext);
      }
      $(this).parent().prev().toggle();
      $(this).prev().toggle();
      return false;
  });

}
