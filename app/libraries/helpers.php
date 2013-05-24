<?php

  /**
   * This function returns a string of classes that identify the current page
   * @return string Current URL transformed into a HTML class name
   */
function page_name() {
  // TODO: Needs to be made more perfect
  // Keep only alfanumeric characters
  $string = preg_replace("/[^A-Za-z\/]+/", "", $_SERVER["REQUEST_URI"]);

  // Put the chunks in an array and remove the empty elements
  $chunks = explode('/', $string);
  $chunks = array_values(array_filter($chunks));

  // If no elements are left, we are on the front page
  if(empty($chunks)) {
    return "front";
  }

  // Loop over the chunks so "aaa/bbb/ccc" returns "aaa aaa-bbb aaa-bbb-ccc"
  for($i = 0; $i < count($chunks); $i++) {
    $chunks_array = array();
    for($j=0; $j <= $i; $j++) {
      $chunks_array[] = $chunks[$j];
    }
    $classes[] = 'page-' . implode('-', $chunks_array);
  }

  return implode(' ', $classes);
}


  /**
   * This function returns an array of rules that matches the input fields
   * @param Array $input An array of field name, field value pairs
   *                     like returned by Input::all()
   * @param Array $rules An array of field name, rules string (piped)
   * @return Array All rules that are applicable to the input
   */
function input_rules($input, $rules) {
  $rules = array_intersect_key($rules, $input); //only the ones in input as well
  $rules = filter_confirmed_rule($rules, $input);
  return $rules;
}


  /**
   * This function is for development purposes
   * It dumps a variable to the message area and in the Log
   *
   * @param var $var Variable to dump
   */
function dpm($var) {
  $pp = print_r($var, true);

  Messages::status("<pre>$pp</pre>");
  Log::info($pp);
}


/******************
PRIVATE
******************/

/**
 * This function returns returns a rules array with the 'confirmed' rules
 * removed if the correspronding "_confirmed" field is not present in the $input
 * @param Array $rules An array of Rules
 * @param Array $input An array of field name, field value pairs
 *                     like returned by Input::all()
 * @return Array An array of Rules
 */
function filter_confirmed_rule($rules, $input) {
  // Remove the confirmed rule from $applicable_rules if the corresponding
  //
  foreach($rules as $field => &$rules_string) {
    // Standardize: Remove all whitespace from the string and put it lowercase
    $rules_string = strtolower(preg_replace('/\s+/', '', $rules_string));

    // Check if the "confirmed" rule is applied
    // If it is applied, without having the rorresponding _confirmed key in
    // the input, remove it
    $rules_array = explode("|", $rules_string);
    $confirmed_keys = array_keys($rules_array, 'confirmed');

    if(!empty($confirmed_keys)
                       && !array_key_exists($field . '_confirmation', $input)) {
      // To be able to use array_diff_key we need to make sure the values
      // and keys are the same
      $confirmed_keys = array_combine($confirmed_keys, $confirmed_keys);

      // Remove all occurencus of the 'confirmed rule'
      $rules_array = array_diff_key($rules_array, $confirmed_keys);
    }
    $rules_string = implode('|', $rules_array);
  }

  return $rules;
}