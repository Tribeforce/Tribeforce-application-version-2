<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {
  /**
   * Validates input against validation rueles.
   *
   * @param string $input Input array
   * @return Validator
   */
    public static function getValidator($input) {
      $rules = array(
        'email'     => 'required|email|between:4,255',
        'password'  => 'required|min:4|confirmed',
        'password_confirmation'=> 'required|min:4',
      );

      return Validator::make($input, input_rules($input, $rules));
    }

  /**
   * Accessor for settings. Unserialized
   *
   * @param Object $value Original value
   * @return string Unserialized version of the original value
   */
    public function getSettings($value) {
      return unserialize($value);
    }

  /**
   * Mutator for settings. Serialized
   *
   * @param Object $value Original value
   */
    public function setSettings($value) {
      if(empty($value)) {
        $this->attributes['settings'] = null; // to prevent values like a:0:{}
      } else {
        $this->attributes['settings'] = serialize($value);
      }
    }

  /**
   * Set an individual setting
   *
   * @param Array $key   The name of the setting to be set
   * @param Array $value The value of the setting to be set
   */
    public function setSetting($key, $value) {
      $settings = $this->getSettings($this->settings);
      array_set($settings, $key, $value);
      $this->setSettings($settings);
    }

  /**
   * Get an individual setting
   *
   * @param Array $key     The name of the setting to get
   * @param value $default An optional default value
   * @return value The stting
   */
    public function getSetting($key, $default = null) {
      $settings = $this->getSettings($this->settings);
      return array_get($settings, $key, $default);
    }

  /**
   * Forget an individual setting
   *
   * @param Array $key The name of the setting to get
   */
    public function forgetSetting($key) {
      $settings = $this->getSettings($this->settings);
      array_forget($settings, $key);
      $this->setSettings($settings);
    }
/*
    public static function current() {
      $user = Sentry::getUser();
      $user = cast('User', $user);
      return $user;
    }
*/
}
