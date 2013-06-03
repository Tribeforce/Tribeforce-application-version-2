<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {
    private static $allSettings = array(
      'language' => array(
        'type' => 'select',
        'values' => array('en', 'nl'),
      ),
      'timezone' => array(
        'type' => 'select',
        'values' => array('zone1', 'zone2'),
      ),
      'locale'=> array(
        'type' => 'select',
        'values' => array('loc1', 'loc2'),
      ),
    );

    public static function getAllSettings() {
      return self::$allSettings;
    }

    public function hasGroup($group_name) {
      $group = Sentry::getGroupProvider()->findByName($group_name);
      return $this->inGroup($group);
    }

    public static function current() {
      $user = Sentry::getUser();
      return cast('User', $user);
    }

    public function full_name() {
      return $this->first_name . " ". $this->last_name;
    }




  /**
   * Validates input against validation rueles.
   *
   * @param string $input Input array
   * @return Validator
   */
    public static function getValidator($input) {
      $rules = array(
        'first_name'=> 'required|alpha_dash|max:255',
        'last_name' => 'required|alpha_dash|max:255',
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
    public static function forgetSetting($key) {
      $settings = $this->getSettings($this->settings);
      array_forget($settings, $key);
      $this->setSettings($settings);
    }


}
