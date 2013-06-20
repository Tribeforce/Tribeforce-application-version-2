<?php

/**
 * This class manages the status messages that appear on the top off the screen
 * @package Messages
 */
class Messages {

  /**
   * @type string $types holds the allowed types mor messages
   */
  private static $types = array('help', 'status', 'warning', 'error');

  /**
   * This function adds a message to the session using Session::flash()
   * @param string $key  The key of the message to be found in the translations
   * @param string $type The message type (has to be one of $types)
   * @param array  $params If the translation has parameters, we pass them here
   * @param string $raw  If set, the value given in $key will be set,
   *                     bypassing any translation
   */
  public static function push($type, $key, $params = array(), $raw = false) {
    if(!empty($key) && in_array($type , self::$types)) {
      $messages = Session::get('messages');
      if($raw) {
        $messages[$type][] = $key;
      }
      else {
        $messages[$type][$key] = trans($key, $params);
      }
      Session::put('messages', $messages);
    } else {
      throw new \InvalidArgumentException('The second argument is invalid.');
    }
  }

  /**
   * This function gets the messages to be shown
   * @param string $type Only het messages of this type
   */
  public static function get($type = 'all') {
    $messages = Session::get('messages');
    Session::forget('messages');

    if($type === 'all') {
      return $messages;
    } elseif(in_array($type , self::$types)) {
      return $messages[$type];
    } else {
      throw new \InvalidArgumentException('The argument is invalid.');
    }
  }

  /**
   * This function returns the AJAX commands to show a message and hide it again
   HTML of 1 message adds a message to the session using Session::flash()
   * @param string $key  The key of the message to be found in the translations
   * @param string $type The message type (has to be one of $types)
   * @param array  $params If the translation has parameters, we pass them here
   * @param string $raw  If set, the value given in $key will be set,
   *                     bypassing any translation
   * @return AJAX command
   */

  public static function show($type, $key, $params = array(), $raw = false) {
    if(!empty($key) && in_array($type , self::$types)) {
      $timestamp = time();

      // Add the message
      $commands[] = array(
        'method' => 'append',
        'selector' => '#messages .columns',
        'html' => html4ajax(View::make('message')->with(array(
          'type'    => $type,
          'message' => $raw ? $key : trans($key, $params),
        )), $timestamp),
      );

      // Remove the message after some seconds
      $commands[] = array(
        'method' => 'remove',
        'selector' => "#messages .columns .ts-$timestamp",
        'timer' => 5000,
      );

      return $commands;
    } else {
      throw new \InvalidArgumentException('The second argument is invalid.');
    }
  }


  public static function __callStatic($name, $arguments) {
    if(in_array($name, self::$types)) {
      if(isset($arguments[1])) {
        self::push($name, $arguments[0], $arguments[1]);
      } else {
        self::push($name, $arguments[0]);
      }
    } else {
      throw new \BadMethodCallException("Method $name is invalid");
    }
  }
}
