<?php
$grid = isset($grid) && $grid;
?>

@foreach($menu as $key => $values)
<li class="{{ $key }}">
  <a href="{{$values['uri']}}">
    <i class="{{$values['icon']}}"></i>
    @lang("ui.menu.$key")
  </a>
</li>
@if(!$grid)
<li class="divider"></li>
@endif
@endforeach
