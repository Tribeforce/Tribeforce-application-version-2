<?php

class Occupation extends Eloquent {
  /**
   * Validates input against validation rules.
   *
   * @param string $input Input array
   * @return Validator
   */
  public static function getValidator($input) {
    $rules = array(
      'name'=> 'required|max:255',
    );

    return Validator::make($input, input_rules($input, $rules));
  }

  public function user() {
    return $this->belongsTo('User');
  }
}
