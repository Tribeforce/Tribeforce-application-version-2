@foreach($menu as $item)
<li class="{{ $item }}">
  {{ HTML::link($item, trans("ui.menu.$item")) }}
</li>
@if(!(isset($divider) && !$divider))
<li class="divider"></li>
@endif
@endforeach
