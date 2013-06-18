<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {
  // members
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

  private static $allTypes = array(
    0 => 'employee',
    1 => 'independant',
    2 => 'former',
  );

  /**
   * Get the private $allSettings
   *
   * @return array
   */
  public static function getAllSettings() {
    return self::$allSettings;
  }

  /**
   * Get the private $allTypes
   *
   * @return array
   */
  public static function getAllTypes() {
    return self::$allTypes;
  }

  /**
   * Checks if a user belongs to a group.
   *
   * @param string $group_name
   * @return Boolean
   */
  public function hasGroup($group_name) {
    $group = Sentry::getGroupProvider()->findByName($group_name);
    return $this->inGroup($group);
  }

  /**
   * Returns the current User object.
   *
   * @return User
   */
  public static function current() {
    $user = Sentry::getUser();
    return cast('User', $user);
  }

  /**
   * Returns the first name concatenated with the last name.
   *
   * @return string
   */
  public function getFullNameAttribute() {
    return $this->first_name . " ". strtoupper($this->last_name);
  }




  /**
   * Validates input against validation rules.
   *
   * @param string $input Input array
   * @return Validator
   */
  public static function getValidator($input) {
    $rules = array(
      'first_name'=> 'required|max:255',
      'last_name' => 'required|max:255',
      'email'     => 'required|email|between:4,255',
      'type'     => 'in:' . implode(',', array_keys(self::$allTypes)),
      'password'  => 'required|min:4|confirmed',
      'password_confirmation'=> 'required|min:4',
      'avatar'=> 'image',
      'birth_date'=> 'date|before:"18 years ago"',
      'hire_date'=> 'date',
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
   * @param string $key     The name of the setting to get
   * @param value  $default An optional default value
   * @return value The stting
   */
    public function getSetting($key, $default = null) {
      $settings = $this->getSettings($this->settings);
      return array_get($settings, $key, $default);
    }

  /**
   * Forget an individual setting
   *
   * @param string $key The name of the setting to forget
   */
    public static function forgetSetting($key) {
      $settings = $this->getSettings($this->settings);
      array_forget($settings, $key);
      $this->setSettings($settings);
    }


// RELATIONSHIPS


  /**
   * Set the relation with the company
   * @return The relation
   */
    public function company() {
      return $this->belongsTo('Company');
    }

  /**
   * Set the relation with the occupation
   * @return The relation
   */
    public function occupation() {
      return $this->hasOne('Occupation');
    }

  /**
   * Set the poymorphic relation with the feedback
   * @return The relation
   */
    public function feedbacks() {
      return $this->morphMany('Feedback', 'source');
    }



// HELPERS


  /**
   * Handle a file upload
   *
   * @param string $name  The name of the file. Can be avatar, cv, motivation, ...
   *                      The name should correspond with a field on the object
   * @param object $object
   * @return boolean
   */
  public function handleUpload($name) {
    if(Input::hasFile($name)) {
      $file = Input::file($name);
      $extension = $file->guessExtension();
      $filename = $name . "." . $this->id . ".$extension";

      // Make the desination folder if needed
      $dest_dir = storage_path() . "/files/$name";
      if(!file_exists($dest_dir)) mkdir($dest_dir, 0770, true);

      // Copy over the file
      if($file->move($dest_dir, $filename)) {
  //        Messages::status('ui.upload_succes');
        // Set the field on the object TODO: Only the extension is strictly needed
        $this->$name = $filename;
        $this->save();
      }
    }
  }


}
