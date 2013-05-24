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

}
