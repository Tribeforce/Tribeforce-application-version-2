<?php

class Feedback extends Eloquent {

  protected $fillable = array('feedback');


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



// RELATIONSHIPS


  /**
   * Set the polymorphic relation with the source
   * @return The relationship
   */
  public function source() {
    return $this->morphTo();
  }
}
