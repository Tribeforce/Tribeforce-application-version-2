<!DOCTYPE HTML>
<html lang="{{ Config::get('app.locale')}}">
  <head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <script src="/js/vendor/custom.modernizr.js"></script>
    <link rel="stylesheet" href="/css/app.css" />
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,700' rel='stylesheet' type='text/css'>
  </head>
  <body class="{{ page_name() }}">
    @yield('body')

    <?php //TODO: update zepto or jquery to the latest versions ?>
    <script>
    document.write('<script src=' +
    ('__proto__' in {} ? '/js/vendor/zepto' : '/js/vendor/jquery') +
    '.js><\/script>')
    </script>

    <?php //TODO: Find and include the foundation.min.js ?>
    <script src="/js/foundation/foundation.js"></script>
    <script src="/js/foundation/foundation.section.js"></script>
    <script src="/js/foundation/foundation.joyride.js"></script>
    <script src="/js/foundation/foundation.clearing.js"></script>
    <script src="/js/foundation/foundation.magellan.js"></script>
    <script src="/js/foundation/foundation.tooltips.js"></script>
    <script src="/js/foundation/foundation.topbar.js"></script>
    <script src="/js/foundation/foundation.alerts.js"></script>
    <script src="/js/foundation/foundation.forms.js"></script>
    <script src="/js/foundation/foundation.orbit.js"></script>
    <script src="/js/foundation/foundation.reveal.js"></script>
    <script src="/js/foundation/foundation.placeholder.js"></script>
    <script src="/js/foundation/foundation.dropdown.js"></script>
    <script src="/js/foundation/foundation.cookie.js"></script>

    <script>
      $(document).foundation();
    </script>
    <script src="/js/script.js"></script>
  </body>
</html>