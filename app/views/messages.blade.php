<?php
$messages = Messages::get();  // NULL if it doesn't exist
?>

@if(!empty($messages))
<div id="messages" class="row">
  <div class="columns">
    @foreach($messages as $type => $typed_messages)
      @foreach($typed_messages as $message)
        <div data-alert class="{{$type}}">
          {{ $message }}
          {{ link_to('#', '&times;', array('class' => 'close')) }}
        </div>
      @endforeach
    @endforeach
  </div>
</div>
@endif
