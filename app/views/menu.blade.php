{{--
This template expects following variables:
- Mandatory
- Optional
--}}

<ul id="menu" class="large-block-grid-3 small-block-grid-2">
  @foreach($menu as $item)
    <li class="{{ $item }}">
      <div class="container">
        {{ HTML::link($item, trans("ui.menu.$item")) }}
      </div>
    </li>
  @endforeach
</ul>
