<?php

class ApplicationController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth', array('only' => 'getIndex'));
    $this->beforeFilter('csrf', array('on' => 'post'));
  }

  private function getMenu() {
    return array(
      'feedback',
      'roles',
      'recruit',
      'admin',
    );
  }

  // Show the Dashboard page
  public function getIndex() {
    return View::make('dashboard', array(
      'title' => trans('ui.title_dashboard'),
      'menu' => $this->getMenu(),
    ));
  }

  // Handle the login
  public function getLogin() {
    // TODO: What to do if the user is already logged in
    return View::make('login', array('title' => trans('ui.title_login')));
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
    return View::make('register', array('title' => trans('ui.title_register')));
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

}
