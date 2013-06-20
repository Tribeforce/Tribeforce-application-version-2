<?php

  /**
   * This function returns a string of classes that identify the current page
   * @return string Current URL transformed into a HTML class name
   */
function page_name() {
  // TODO: Needs to be made more perfect
  // Keep only alfanumeric characters
  $string = preg_replace("/[^A-Za-z\/]+/", "", Request::path());

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
   * Get the name of the calling function
   *
   * @return string The name of the calling function
   */
  function get_caller() {
    // TODO: This is performance wise VERY heavy
    //       Probably this should not be used. We should pass the functionname
    //       as parameter where used (__FUNCTION__
    $callers = debug_backtrace(false);
    $caller = $callers[2]['function'];
    return $caller;
  }


  /**
   * This function is for development purposes
   * It dumps a variable to the message area and in the Log
   *
   * @param var $var Variable to dump
   */
function dpm($var) {
  $pp = print_r($var, true);

  Messages::push('status', "<pre>$pp</pre>", null, true);
  Log::info($pp);
}

function randomString() {
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randstring = '';
  for ($i = 0; $i < 8; $i++) {
    $randstring = $chars[rand(0, strlen($chars)-1)];
  }
  return $randstring;
}



/**
 * Cast an object to another class, keeping the properties, but changing the methods
 *
 * @param string $class  Class name
 * @param object $object
 * @return object
 */
function cast($class, $object) {
  return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
}


/**
 * Prepare the array of key values to be used in a select form element
 *
 * @param string $prefix The prefix to do the translation
 *                       (example: forms.settings.language)
 * @param array  $keys   An array holding the keys of the select. Those keys
 *                       with the $prefix will then be used for the translation.
 * @return array key values to be used in a select form element
 */
function key_val($prefix, $keys) {
  // Fill the array with keys with no value
  $key_val = array_fill_keys($keys, '');

  // Fill the empty values with the translation
  array_walk($key_val, function(&$value, $key, $prefix) {
    $value = trans("$prefix.$key");
  }, $prefix);

  return $key_val;
}



function html4ajax($html, $timestamp = null) {
  $classes = isset($timestamp) ? "ajax ts-$timestamp": "ajax";
  return utf8_encode('<div class="' . $classes . '">' . $html . '</div>');
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
