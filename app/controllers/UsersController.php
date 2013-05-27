<?php

class UsersController extends \BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
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
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store()
  {
    //
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
    $input = Input::except('groups', '_method','_token');

    // Validate the input
    $validator = User::getValidator($input);
    if ($validator->fails()) {
      // TODO: use route('users.update')
      return Redirect::back()->withInput()->withErrors($validator);
    }

    $user = User::find($id);

    // Set the normal fields
    foreach($input as $name => $value) {
      $user->$name = $value;
    }

    // Set the group fields
    $input = Input::only('groups');
    if(isset($input['groups'])) {
      foreach($input['groups'] as $group_name => $checked) {
        $group = Sentry::getGroupProvider()->findByName($group_name);
        $checked ? $user->addGroup($group) : $user->removeGroup($group);
      }
    }

    // Set the settings fields

    // Finally save the user
    $user->save();

    return Redirect::back();
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
        'title' => trans("ui.users.title_$caller", array('name' => $user->id)),
      ));
    } else {
      return View::make("users.$caller");
    }
  }

}
