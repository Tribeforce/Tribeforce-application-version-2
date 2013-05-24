<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'users';

  /**
   * The attributes excluded from the model's JSON form.
   *
   * @var array
   */
  protected $hidden = array('password');


  // Add to the "fillable" array
//  protected $fillable = array('email', 'password');



  /**
   * Get the unique identifier for the user.
   *
   * @return mixed
   */
  public function getAuthIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Get the password for the user.
   *
   * @return string
   */
  public function getAuthPassword()
  {
    return $this->password;
  }

  /**
   * Get the e-mail address where password reminders are sent.
   *
   * @return string
   */
  public function getReminderEmail()
  {
    return $this->email;
  }


  /**
   * Validates input against validation rueles.
   *
   * @param string $input Input array
   * @return Validator
   */
    public static function validate($input) {
      $rules = array(
        'email'     => 'required|email|between:4,255',
        'password'  => 'required|min:4|confirmed',
        'password_confirmation'=> 'required|min:4',
      );

      return Validator::make($input, input_rules($input, $rules));
    }


}
