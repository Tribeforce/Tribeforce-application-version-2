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




});

/**** GLOBAL FUNCTIONS ****/
accordeonSlide = function(options) {
//  $('.section-container .content').slideUp();
  $('.section-container .active .content').css('display', 'none').slideDown();
};
