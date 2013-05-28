<?php
/*
This template expects following variables:
- Mandatory
  $d : user object
- Optional
*/

// Prepare variables
$settings = User::getAllSettings();

?>

<div>
  <?php // Label ?>
  {{ Form::label('groups', trans("forms.settings_name")) }}

  <?php // Field
  foreach($settings as $setting_name => $setting) {
    $key_val = array_fill_keys($setting['values'], '');
    array_walk($key_val, function(&$value, $key, $setting_name) {
      $value = trans("forms.settings.$setting_name.$key");
    }, $setting_name);

    $params = array(
      'type'    => $setting['type'],
      'name'    => 'settings['.$setting_name.']',
      'values'  => $key_val,
      'default' => $d->getSetting($setting_name),
    );
  ?>
    @include('form.field', $params)
  <?php } ?>
</div>
