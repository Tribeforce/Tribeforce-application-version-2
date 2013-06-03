<?php
$grid = isset($grid) && $grid;
?>

@foreach($menu as $item => $uri)
<li class="{{ $item }}">
  @if($grid)
  <div class="container">
  @endif
    {{ HTML::link($uri, trans("ui.menu.$item")) }}
  @if($grid)
  </div>
  @endif
</li>
@if(!$grid)
<li class="divider"></li>
@endif
@endforeach
