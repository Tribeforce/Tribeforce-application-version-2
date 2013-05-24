<?php
$messages = Messages::get();  // NULL if it doesn't exist
?>

@if(!empty($messages))
<div id="messages" class="row">
  <div class="columns">
    @foreach($messages as $type => $typed_messages)
      <ul class="{{ $type }}">
        @foreach($typed_messages as $message)
          <li>{{ $message }}</li>
        @endforeach
      </ul>
    @endforeach
  </div>
</div>
@endif
