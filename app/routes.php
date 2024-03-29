<?php
use Illuminate\View\Environment;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('users', 'UsersController');
Route::resource('files', 'FilesController');
Route::resource('feedback', 'FeedbackController');

Route::controller('tribe', 'TribeController');


Route::controller('/', 'ApplicationController');
