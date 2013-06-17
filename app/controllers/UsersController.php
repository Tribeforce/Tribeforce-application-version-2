<?php

class UsersController extends \BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('admin', array('only' => array(
      'index',
      'create',
      'store',
      'destroy',
    )));
  }


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $users = Sentry::getUserProvider()->findAll();

    return View::make("users.index")->with(array(
      'd' => $users,
      'title' => trans("ui.users.title_index"),
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    return View::make("users.create")->with(array(
      'title' => trans("ui.users.title_create"),
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    return $this->upsert();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    return $this->generate_view($id);
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    return $this->generate_view($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    return $this->upsert($id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    //
  }



/*******************************************************************************
PRIVATE
*******************************************************************************/



  /**
   * This is a helper function that is used to call the correct view.
   * The view needs to have the same name as the the Route name
   * The title is taken from the ui translation file and the keyname must be:
   *   title_<Route name>
   *   example: title_show or title_index
   *
   * @param  int  $id
   */
  private function generate_view($id = null) {
    $caller = get_caller();

    // Only load the user if the $id has been given
    if(!empty($id)) {
      $user = User::find($id);
      return View::make("users.$caller")->with(array(
        'd' => $user,
        'title' => trans("ui.users.title_$caller", array('name' => $user->full_name)),
      ));
    } else {
      return View::make("users.$caller");
    }
  }



  /**
   * When using the pickdate.js library, hidden fields will be added holding the
   * machine readible balue of the date. Those fields have the name of the
   * original feields, with the suffix: "_submit".
   * This function intends to remove the useless original key values for date
   * fields and replace the suffixed key values by the original key values
   * (without suffix).
   *
   * Example:
   *   'birth_date' => 'Today',
   *   'birth_date_submit' => '2013/06/15',
   * will be transformed to:
   *   'birth_date' => '2013/06/15',
   * @param  array  $input The input array: We assume the _submit versions are
   *                       always after the original versions when looping over
   *                       the array
   * @return array The updated array
   */
  private function prepare_date_fields($input) {
    $suffix = '_submit';
    $ret = array();

    foreach($input as $key => $value) {
      if(strrpos($key, $suffix) === FALSE) { // Just copy over
        $ret[$key] = $value;
      } else { // replacement needs to happen
        $new_key = substr($key, 0, strlen($key) - strlen($suffix));
        $ret[$new_key] = $value;
      }
    }

    return $ret;

  }

  /**
   * Helper function to insert or update a user
   * @param  integer  $id If it is a update, the ID is given here
   * @return  RedirectResponse  The new or updated User
   */
  private function upsert($id = null) {
    $new = isset($id) ? false : true;

    $input = Input::except('settings', 'groups', '_method','_token');
    $input = $this->prepare_date_fields($input);

    // Validate the input
    $validator = User::getValidator($input);
    if ($validator->fails()) {
      // TODO: use route('users.update')
      return Redirect::back()->withInput()->withErrors($validator);
    }

    $user = $new ? new User : User::find($id);

    // Set the normal fields
    foreach($input as $name => $value) {
      $user->$name = e($value);
    }

    if($new) {
      // Set a dummy password.
      // TODO: Maybe something needs to be done with the password
      $user->password = randomString();

      // Set the company
      $company = User::current()->company;
      $user->company()->associate($company);
    }

    // Save the user
    $user->save();

    // Set the group fields
    $input = Input::only('groups');
    if(isset($input['groups'])) {
      foreach($input['groups'] as $group_name => $checked) {
        $group = Sentry::getGroupProvider()->findByName($group_name);
        $checked ? $user->addGroup($group) : $user->removeGroup($group);
      }
    }

    // Set the settings fields
    $input = Input::only('settings');
    $user->setSettings($input['settings']);

    // Handle the upload
    $user->handleUpload("avatar");

    // Save the user again
    $user->save();

    if($new) {
      Messages::status('ui.created', array('name' => $user->full_name));
      return Redirect::action('TribeController@getIndex');
    } else {
      Messages::status('ui.updated', array('name' => $user->full_name));
      return Redirect::action('TribeController@getDetails', $id);
    }
  }

}
