<?php
$messages = Messages::get();  // NULL if it doesn't exist
?>

<div id="messages" class="row">
  <div class="columns">
  @if(!empty($messages))
    @foreach($messages as $type => $typed_messages)
      @foreach($typed_messages as $message)
        @include('message')
      @endforeach
    @endforeach
  @endif
  </div>
</div>
