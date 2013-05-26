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
   * @param string $message The message to be shown
   * @param string $type2 The message type (has to be one of $types)
   */
  public static function push($message, $type) {
    if(!empty($message) && in_array($type , self::$types)) {
      $messages = Session::get('messages');
      $messages[$type][] = $message;
      Session::put('messages', $messages);
    } else {
      throw new \InvalidArgumentException('The second argument is invalid.');
    }

  }

  /**
   * This function adds a message to the session using Session::flash()
   * @param string $message The message to be shown
   * @param string $type2 The message type (has to be one of $types)
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

  public static function __callStatic($name, $arguments) {
    if(in_array($name , self::$types)) {
      self::push($arguments[0], $name);
    } else {
      throw new \BadMethodCallException("Method $name is invalid");
    }
  }
}
