<?php
/*
This template expects following variables:
- Mandatory
  - $type
  - $message
*/
?>
<div data-alert class="{{$type}}">
  {{ $message }}
  {{ link_to('#', '&times;', array('class' => 'close')) }}
</div>
