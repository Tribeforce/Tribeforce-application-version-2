<?php
/*
This template expects following variables:
- Mandatory
  - $source_id:   the id of the source to add the feedback to
  - $source_type: the type of the source to add the feedback to
*/
?>

{{ Form::open(array('url' => 'feedback')) }}
  <div class="actions">
    @include('form.field', array('type' => 'submit', 'name' => 'ready', 'size' => 'tiny'))
    {{ link_to_route('feedback.store', trans('forms.cancel'), null, array('class' => 'ajax button secondary cancel right tiny')) }}
  </div>
  {{ Form::hidden('source_id'  , $source_id)   }}
  {{ Form::hidden('source_type', $source_type) }}
  @include('form.field', array('type' => 'textarea', 'name' => 'feedback', 'sl' => false))
{{ Form::close() }}
