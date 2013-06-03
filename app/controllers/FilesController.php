<?php

class FilesController extends \BaseController {

  private static $dir;

  public function __construct() {
    $this->beforeFilter('auth');
    self::$dir = app_path() . '/storage/files';
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
    return View::make("files.create")
                 ->with('title', trans('ui.files.title_create'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = Input::all();
    if(Input::hasFile('image')) {
      $file = Input::file('image');
      $filename = $input['name'];
      $extension = $file->guessExtension();
      $dest_dir = self::$dir .'/'. User::current()->id;
      if(!file_exists($dest_dir)) mkdir($dest_dir, 0770, true);
      if($file->move($dest_dir, "$filename.$extension")) {
        Messages::status('ui.upload_succes');
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id) {
    $file_path = self::$dir .'/'. User::current()->id . '/' .$id;
    if(file_exists($file_path)) {
      $file = new Symfony\Component\HttpFoundation\File\File($file_path);
      $content_type = $file->getMimeType();
      $contents = file_get_contents($file_path);
      $response = Response::make($contents, 200);
      $response->header('Content-Type', $content_type);
      return $response;
    }

    App::abort(404, 'Resource not found');
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
