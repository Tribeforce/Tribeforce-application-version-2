<?php
/*
This template expects following variables:
- Mandatory
- Optional
  $d : user object
*/

// Prepare variables
$settings = User::getAllSettings();

?>

<fieldset class="collapsed">
  <legend>@lang("forms.settings_name")</legend>
  <?php
  foreach($settings as $setting_name => $setting) {
    $params = array(
      'type'    => $setting['type'],
      'name'    => 'settings['.$setting_name.']',
      'values'  => key_val("forms.settings.$setting_name", $setting['values']),
      'default' => isset($d) && $d->getSetting($setting_name) ? $d->getSetting($setting_name) : false,
    );
  ?>
    @include('form.field', $params)
  <?php } ?>
</fieldset>
