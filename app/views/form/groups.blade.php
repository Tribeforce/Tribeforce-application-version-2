<?php
/*
This template expects following variables:
- Mandatory
- Optional
*/

// Prepare variables
$groups = Sentry::getGroupProvider()->findAll();

?>

<div>
  <?php // Label ?>
  {{ Form::label('groups', trans("forms.groups")) }}

  <?php // Field ?>
  @foreach($groups as $group)
    @include('form.field', array('type' => 'switch', 'name' => 'groups['.$group->name.']', 'checked' => $d->inGroup($group)))
  @endforeach
</div>
