<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request) {
  // TODO: Simplify this between the case for logged in and non logged in
  $user = User::current();
  $dflt_lang = 'en'; // Set the default language
  $user_lang = is_object($user) ? $user->getSetting('language') : $dflt_lang;
  $user_lang = empty($user_lang) ? $dflt_lang : $user_lang;
  App::setLocale($user_lang);
  Config::set('tf.version', '2.0');
  View::share('menu', Menu::get());
  View::share('current_user', $user);
  if(is_object($user)) {
    View::share('is_admin', User::current()->hasGroup('admin'));
  } else {
    View::share('is_admin', false);
  }
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function() {
  if (!Sentry::check()) {
    Messages::error('exceptions.not_logged_in');
    return Redirect::guest('login');
  }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
//  if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
  if (Session::token() != Input::get('_token'))
  {
    throw new Illuminate\Session\TokenMismatchException;
  }
});



/*
For pages that are only accessible for users in the 'admin' group
*/
Route::filter('admin', function() {
  if( ! User::current()->hasGroup('admin')) {
    throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
  }
});


/*
Make sure we only access what is from our company
*/
Route::filter('own', function($route, $request, $value) {
  if($value === 'files') {
    $filename = Route::getCurrentRoute()->getParameter('files');

    $user_id = explode('.', $filename)[1];
    $user = User::find($user_id);

    if(User::current()->company != $user->company) {
      throw new Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
    }

  }

});
