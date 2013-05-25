<?php

class ApplicationController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth', array('only' => 'getIndex'));
    $this->beforeFilter('csrf', array('on' => 'post'));
  }


  // Show the Dashboard page
  public function getIndex() {
    return View::make('dashboard')
                 ->with(array('title' => trans('ui.title_dashboard')));
  }

  // Handle the login
  public function getLogin() {
    // TODO: What to do if the user is already logged in
    return View::make('login')->with(array('title' => trans('ui.title_login')));
  }



  // Handle the login form data
  public function postLogin() {
    // Validate the input
    $validator = User::getValidator(Input::all());

    if ($validator->fails()) {
      return Redirect::to('login')->withInput()->withErrors($validator);
    }

    // Try to authenticate the user
    try {
      $credentials = array(
        'email' => Input::get('email'),
        'password' => Input::get('password'),
      );

      // TODO:Set to true to remember
      $user = Sentry::authenticate($credentials, false);

      Sentry::login($user, false);

      return Redirect::intended('/');

    }
/* This can never happen because of the validation before
    catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
        echo 'Login field is required.';
    } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
        echo 'Password field is required.';
    }
*/
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      Messages::error(trans('exceptions.Sentry.UserNotFoundException'));
    } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
      Messages::error(trans('exceptions.Sentry.WrongPasswordException'));
    } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      Messages::error(trans('exceptions.Sentry.UserNotActivatedException'));
    } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      Messages::error(trans('exceptions.Sentry.UserSuspendedException'));
    }catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      Messages::error(trans('exceptions.Sentry.UserBannedException'));
    }

    // If we didn't return in the try block, we need to go back
    return Redirect::to('login')->withInput();
  }




  // Log the user out
  public function getLogout() {
    Sentry::logout();
    return Redirect::to('/');
  }




  // Show the settings page of the user
  public function getSettings() {
    return Redirect::to('/');
  }




  // Show the registration page
  public function getRegister() {
    return View::make('register')
                 ->with(array('title' => trans('ui.title_register')));
  }

  // Handle the registration form
  public function postRegister() {
    // Validate the input
    $validator = User::getValidator(Input::all());

    if ($validator->fails()) {
      return Redirect::to('register')->withInput()->withErrors($validator);
    }

    try {
      // Create the user
      $user = Sentry::register(array(
        'email' => Input::get('email'),
        'password' => Input::get('password'),
      ), true);

      Messages::status('ui.user_created', array('user' => $user->email));

      // Find the group using the group id
//TODO      $adminGroup = Sentry::getGroupProvider()->findById(1);

      // Assign the group to the user
//TODO      $user->addGroup($adminGroup);

    } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
      Messages::error(trans('exceptions.Sentry.UserExistsException'));
    } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
      Messages::error(trans('exceptions.Sentry.GroupNotFoundException'));
    }
/* This can never happen because of the validation before
    catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
        echo 'Login field is required.';
    } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
        echo 'Password field is required.';
    }
*/

    return Redirect::to('/');

  }

  // The Facebook OAuth path
  public function getFacebook() {
    define('CONF_FILE', app_path().'/config/opauth.conf.php');
    require CONF_FILE;
    $Opauth = new Opauth( $config );
  }

  /**
   * Callback for Opauth
   *
   * This file (callback.php) provides an example on how to properly receive auth response of Opauth.
   *
   * Basic steps:
   * 1. Fetch auth response based on callback transport parameter in config.
   * 2. Validate auth response
   * 3. Once auth response is validated, your PHP app should then work on the auth response
   *    (eg. registers or logs user in to your site, save auth data onto database, etc.)
   *
   */
  public function anyDone() {
    define('CONF_FILE', app_path().'/config/opauth.conf.php');
    require CONF_FILE;
    $Opauth = new Opauth( $config, false );

    /**
    * Fetch auth response, based on transport configuration for callback
    */
    $response = null;

    switch($Opauth->env['callback_transport']) {
      case 'session':
        if(session_id() == '') session_start();
        $response = $_SESSION['opauth'];
        unset($_SESSION['opauth']);
        break;
      case 'post':
        $response = unserialize(base64_decode( $_POST['opauth'] ));
        break;
      case 'get':
        $response = unserialize(base64_decode( $_GET['opauth'] ));
        break;
      default:
        Messages::error(trans('exceptions.Opauth.callback'));
        break;
    }


    /**
     * Check if it's an error callback
     */
    if (array_key_exists('error', $response)) {
     Messages::error(trans('exceptions.Opauth.error'));
    }

    /**
     * Auth response validation
     *
     * To validate that the auth response received is unaltered, especially auth response that
     * is sent through GET or POST.
     */
    else {
      if (empty($response['auth']) || empty($response['timestamp'])
      || empty($response['signature']) || empty($response['auth']['provider'])
      || empty($response['auth']['uid'])) {
        Messages::error(trans('exceptions.Opauth.missing'));
      } elseif (!$Opauth->validate(sha1(print_r($response['auth'], true)),
                     $response['timestamp'], $response['signature'], $reason)) {
        Messages::error(trans('exceptions.Opauth.reason',
                                                   array('reason' => $reason)));
      } else {
        // LOGGED IN
        $facebook_id = $response['auth']['uid'];
        $provider = $response['auth']['provider'];

        // Check if the user is logged in.
        // If he's logged in, we have a connection request
        // If he's not logged in, we have a login request
        if(Sentry::check()) { // Connection request
          $user = User::current();
          $user->facebook_id = $facebook_id;
          $user->save();
          Messages::status(trans('ui.connection_succes',
                                                array('service' => $provider)));
        } else { // Login request
          // If a user with the facebook_id exists, we log him in
          $user = User::where('facebook_id', '=', $facebook_id)->first();
          if(empty($user)) {
            Messages::status(trans('exceptions.Opauth.not_found'),
                                                array('provider' => $provider));
            return View::make('login')
                              ->with(array('title' => trans('ui.title_login')));

          } else {
            Messages::status(trans('ui.login_succes'));
            Sentry::login($user, false);
          }

        }
        dpm('Logged in');  // TODO: The message doesn't show. The session seems fucked up

        return Redirect::to('/');

      }
    }

    return View::make('login')->with(array('title' => 'dffdgdgdgsdg'));

  }


}
