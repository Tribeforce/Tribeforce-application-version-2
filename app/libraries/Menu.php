<?php

/**
 * This class manages the status messages that appear on the top off the screen
 * @package Messages
 */
class Menu {

  /**
   * This function adds a message to the session using Session::flash()
   * @param string $type The menu type
   */
  public static function get($type = 'main') {
    switch($type) {
      case 'main':
        $menu = array(
          'tribe' => array(
            'uri' => URL::action('TribeController@getIndex'),
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
          'settings'    => array(
            'uri' => URL::action('ApplicationController@getSettings'),
            'icon' => 'gen foundicon-tools',
          ),
          'logout'    => array(
            'uri' => URL::action('ApplicationController@getLogout'),
            'icon' => 'gen foundicon-error',
          ),
        );

        return $menu;
      default:
        throw new \InvalidArgumentException('The type argument is invalid.');
    }
  }

}
