;(function (window, document, $) {
   events = 'click.fndtn';

  // Watch for clicks to show the sidebar
  var $selector2 = $('#sidebarButton');
  if ($selector2.length > 0) {
    $('#sidebarButton').on(events, function (e) {
      e.preventDefault();
      $('body').toggleClass('active');
    });
  }
}(this, document, $));
