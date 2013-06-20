<?php

class FeedbackController extends \BaseController {

  public function __construct() {
    $this->beforeFilter('auth');
    $this->beforeFilter('csrf', array('on' => array('post', 'put')));
  }


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    $source_id   = isset($_GET['source_id'])   ? $_GET['source_id']   : '';
    $source_type = isset($_GET['source_type']) ? $_GET['source_type'] : '';

    if(Request::ajax()) {
      $commands[] = array(
        'method' => 'hide',
        'selector' => ".$source_type-$source_id .actions",
      );

      $commands[] = array(
        'method' => 'append',
        'selector' => ".$source_type-$source_id",
        'html' => html4ajax(View::make('feedback.create')->with(array(
          'source_id'   => $source_id,
          'source_type' => $source_type,
        ))),
      );

      return Response::json($commands);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = Input::all();
    if(Request::ajax()) {
      if(!empty($input['feedback'])) {
        // TODO: Add validation
        $feedback = new Feedback(array('feedback' => $input['feedback']));
        $class = ucfirst(camel_case($input['source_type']));

        // Only continue if the class exists
        if(class_exists($class)) {
          $source = $class::find($input['source_id']);

          // The source class needs to be the same as asked for (not empty also)
          if(get_class($source) === $class) {
            // Save the feedback and show a message
            $feedback = $source->feedbacks()->save($feedback);
            $commands = Messages::show('status', 'ui.feedback.success');
          } else {
            $commands = Messages::show('warning', 'ui.feedback.error');
          }
        } else {
          $commands = Messages::show('warning', 'ui.feedback.error');
        }

      } else {
        $commands = Messages::show('warning', 'ui.feedback.empty');
      }

      // The selector for the parent object
      $selector = '.' . $input['source_type'] . '-' . $input['source_id'];

      // Show the feedback button again
      $commands[] = array(
        'method' => 'show',
        'selector' => "$selector .actions",
      );

      // Remove the form injected by AJAX
      $commands[] = array(
        'method' => 'remove',
        'selector' => "$selector div.ajax",
      );

      return $commands;

    } else {
      // TODO: Code for non AJAX call
    }

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    //
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

}
