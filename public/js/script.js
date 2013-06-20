$(document).ready(function() {
  // Set a minimum height
  // TODO: avoid scrollbars
  $('body').css('minHeight', $(window).height());

  // Attach the datepickers
  var today = new Date();
  $('input#birth_date').pickadate({
    max: new Date(today.getFullYear()-18, today.getMonth(), today.getDate()),
    min: new Date(1900,1,1),
    selectYears: 100
  });

  $('input#hire_date').pickadate({
    max: new Date(today.getFullYear()+1, today.getMonth(), today.getDate()),
    min: new Date(today.getFullYear()-50, today.getMonth(), today.getDate()),
    selectYears: 100
  });


  /**** COLLAPSIBLE FIELDSETS ****/
  // Attach click handler: Make fieldsets collapsible
  $('fieldset legend').click(function(){
    $(this).parent().toggleClass('collapsed');
    $(this).siblings().slideToggle();
  });

  // Slide the collapsed fieldset up on page load
  $('.collapsed legend').each(function() {
    $(this).siblings().slideToggle();
  });

  /**** TOPMENU ANIMATION ****/
  // Attach click handler
  $('nav.top-bar .toggle-topbar').click(function() {
    $selector = $('nav.top-bar section.top-bar-section');
    if($('nav.top-bar').hasClass('expanded')) {
      if($(window).width() < 768) {
        $selector.slideUp();
      }
    } else {
      $selector.slideDown();
    }
  });

  // The resize actions
  $(window).resize(function() {
    $selector = $('nav.top-bar section.top-bar-section');
    if($(window).width() > 520) {
      $selector.slideDown();
    } else {
      $selector.slideUp();
    }
  });

  // On load, we always slide up except if we are in wide screen
  if($(window).width() <= 520) {
    $('nav.top-bar section.top-bar-section').slideUp();
  }


  $.ajaxSetup({
    dataType: 'json',
    statusCode: {  // TODO: Show disappearing message for errors
      404: function() {
        alert("page not found");
      }
    },
    success: function(data, status, jqXHR ) {
      var timer = 0;

      for(i = 0; i < data.length; i++) {
        // Set the timer
        timer = 0;
        if(data[i].timer !== undefined) {
          timer = data[i].timer;
        }

        // Set the selector
        selector = data[i].selector;

        switch(data[i].method) {
          case 'append':
            $(selector).append(data[i].html);
            $(selector + ' div.ajax').slideDown();
            break;
          case 'hide':
            setTimeout(function(s) { s.slideUp(); }, timer, $(selector));
            break;
          case 'show':
            $(selector).softShow();
            break;
          case 'remove':
            setTimeout(function(s) { s.softRemove(); }, timer, $(selector));
            break;
        }
      }
    }
  });

  $.fn.softRemove = function() {
    $(this).slideUp(function() {
      $(this).remove();
    });
  };

  $.fn.softShow = function() {
    $(this).slideDown();
    // Unset the display so it takes the CSS rules
    $(this).css('display', '');
  };

  // Make sure all AJAX links are handled using AJAX
  $('body').delegate('a.ajax', 'click', function(event){
    event.preventDefault();
    url = $(this).attr('href');
    // A cancel has to remove what has been added by AJAX
    if($(this).hasClass('cancel')) {
      $(this).parents('.ajax').softRemove();
      $(this).parents('li').find('.actions').softShow();
    } else { // Normal case
      $.ajax(url);
    }
  });


  // TRIBE INDEX
  $('#tribe-index li')
    .delegate('.ajax input[type=submit]', 'click', function(event){
      event.preventDefault();
      $form = $(this).parents('form');
      url = $form.attr('action');
      data = $form.serialize();

      $.post(url, data);
    });


});

/**** GLOBAL FUNCTIONS ****/
accordeonSlide = function(options) {
//  $('.section-container .content').slideUp();
  console.log(this);
  $('.section-container .active .content').css('display', 'none').slideDown();
};
