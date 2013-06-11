<?php

/**
 * This class manages the status messages that appear on the top off the screen
 * @package Messages
 */
class Menu {

  /**
   * @type string $types holds the allowed types mor messages
   */
  private static $main = array(
    'tribe' => array(
      'uri' => 'tribe',
      'icon' => 'gen foundicon-address-book',
    ),
    'roles'    => array(
      'uri' => 'roles',
      'icon' => 'gen foundicon-folder',
    ),
    'recruit'  => array(
      'uri' => 'recruit',
      'icon' => 'gen foundicon-flag',
    ),
    'admin'    => array(
      'uri' => 'users',
      'icon' => 'gen foundicon-settings',
    ),
  );


  /**
   * This function adds a message to the session using Session::flash()
   * @param string $type The menu type
   */
  public static function get($type = 'main') {
    switch($type) {
      case 'main':
        return self::$main;
      default:
        throw new \InvalidArgumentException('The type argument is invalid.');
    }
  }

}
