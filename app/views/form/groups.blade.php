<?php
/*
This template expects following variables:
- Mandatory
- Optional
  $d : user object
*/

if($is_admin) {
  // Prepare variables
  $groups = Sentry::getGroupProvider()->findAll();
?>
  <fieldset class="collapsed">
    <legend>@lang("forms.groups")</legend>
    <?php
    foreach($groups as $group) {
      $default = isset($d) && $d->inGroup($group) ? true : false; ?>
      @include('form.field', array('type' => 'switch', 'name' => 'groups['.$group->name.']', 'default' => $default))
    <?php } ?>
  </fieldset>
<?php } ?>
