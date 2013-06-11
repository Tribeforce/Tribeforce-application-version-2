<?php

class TribeController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }


  // Show the Dashboard page
  public function getIndex() {
    // Get all the data
    $persons = User::current()->company->users()->orderBy('first_name')->get();

    // Prepare the data
    foreach($persons as $person) {
      $d[$person->type][$person->id] = $person;
    }

    return View::make('tribe.index')->with(array(
      'title' => trans('ui.tribe.title_index'),
      'd' => $d,
    ));
  }

  public function getDetails($id) {
    $d = User::find($id);
    return View::make('tribe.details')->with(array(
      'title' => $d->full_name,
      'd' => $d,
    ));
  }


}
