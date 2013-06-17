<?php

class ApplicationController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth', array('except' => array('getLogin', 'postLogin')));
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }


  // Show the Dashboard page
  public function getIndex() {
    return View::make('dashboard')
                 ->with(array('title' => trans('ui.title_dashboard')));
  }

  // Handle the login
  public function getLogin() {
    if(Sentry::check()) {
      Messages::error('ui.logged_in');
      return Redirect::to('/');
    } else {
      return View::make('login')->with(array('title'=>trans('ui.title_login')));
    }
  }

  // Handle the login form data
  public function postLogin() {
    // Validate the input
    $input = Input::all();
    $validator = User::getValidator($input);
    if ($validator->fails()) {
      // Because we use the foundation switch, we need to make sure the remember
      // value is not passed through as it will set the value to all input
      // fields with name="remember".
      // In the foundation switch 2 radio boxes have the same name: remember
      // We solve this by putting the value to the session and when we retrieve
      // the value (in the view), we forget the value
      Session::put('remember', $input['remember']);
      return Redirect::to('login')->withInput(Input::except('remember'))
                                  ->withErrors($validator);
    }

    // Try to authenticate the user
    try {
      $credentials = array(
        'email' => $input['email'],
        'password' => $input['password'],
      );

      $user = Sentry::authenticate($credentials, $input['remember']);
      Sentry::login($user, $input['remember']);

      return Redirect::intended('/');

    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      Messages::error('exceptions.Sentry.UserNotFoundException');
    } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
      Messages::error('exceptions.Sentry.WrongPasswordException');
    } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
      Messages::error('exceptions.Sentry.UserNotActivatedException');
    } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      Messages::error('exceptions.Sentry.UserSuspendedException');
    }catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      Messages::error('exceptions.Sentry.UserBannedException');
    }

    // If we didn't return in the try block, we need to go back
    Session::put('remember', $input['remember']);
    return Redirect::to('login')->withInput(Input::except('remember'));
  }




  // Log the user out
  public function getLogout() {
    Sentry::logout();
    return Redirect::to('/');
  }




  // Show the settings page of the user
  public function getSettings() {
    $user = Sentry::getUser();
    return Redirect::action('TribeController@getDetails', $user->id);
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
      ));

      Messages::status('ui.user_created', array('user' => $user->email));

    } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
      Messages::error('exceptions.Sentry.UserExistsException');
    } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
      Messages::error('exceptions.Sentry.GroupNotFoundException');
    }

    return Redirect::to('/');

  }

  // The Facebook OAuth path
  public function getFacebook() {
    define('CONF_FILE', app_path().'/config/opauth.conf.php');
    require CONF_FILE;
    $Opauth = new Opauth( $config );
  }

  // The Facebook OAuth path
  public function getForgetFacebook() {
    $user = Sentry::getUser();
    $user->facebook_id = null;
    $user->save();
    Messages::status('ui.fb_forget', array('provider' => "Facebook"));
    return Redirect::back();
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
        Messages::error('exceptions.Opauth.callback');
        break;
    }


    /**
     * Check if it's an error callback
     */
    if (array_key_exists('error', $response)) {
      Messages::error('exceptions.Opauth.error', array('provider'=>'Facebook'));
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
        Messages::error('exceptions.Opauth.missing');
      } elseif (!$Opauth->validate(sha1(print_r($response['auth'], true)),
                     $response['timestamp'], $response['signature'], $reason)) {
        Messages::error('exceptions.Opauth.reason', array('reason' => $reason));
      } else {
        // LOGGED IN
        $facebook_id = $response['auth']['uid'];
        $provider = $response['auth']['provider'];

        // Check if the user is logged in.
        // If he's logged in, we have a connection request
        // If he's not logged in, we have a login request
        if(Sentry::check()) { // Connection request
          $user = Sentry::getUser();
          $user->facebook_id = $facebook_id;
          $user->save();
          Messages::status('ui.connection_succes',array('provider'=>$provider));
          return Redirect::back();
        } else { // Login request
          // If a user with the facebook_id exists, we log him in
          $user = User::where('facebook_id', '=', $facebook_id)->first();
          if(empty($user)) {
            Messages::error('exceptions.Opauth.not_found',
                                                array('provider' => $provider));
            return Redirect::back();
         } else {
            Messages::status('ui.login_succes');
            Sentry::login($user, false);
            return View::make('dashboard')
                         ->with(array('title' => trans('ui.title_dashboard')));
          }
        }
      }
    }

    return View::make('login')->with(array('title' => trans('ui.title_login')));

  }


}
