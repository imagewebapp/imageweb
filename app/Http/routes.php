<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array(
    'uses' => 'ImagesController@showgallery'
));

Route::get('login', array(
    'uses' => 'ImagesController@showloginpage'
));

Route::post('login', array(
    'uses' => 'ImagesController@dologin'
));

Route::get('logout', array(
    'uses' => 'ImagesController@dologout'
));

Route::get('register', array(
    'uses' => 'ImagesController@showregistrationform'
));

Route::post('register', array(
    'uses' => 'ImagesController@doregister'
));

Route::get('dashboard', array(
    'uses' => 'ImagesController@dashboard'
));

Route::get('verify', array(
    'uses' => 'ImagesController@activateregistration'
));

Route::post('upload', array(
    'uses' => 'ImagesController@create'
));

Route::get('download', array(
    'uses' => 'ImagesController@download'
));

Route::get('gallery', array(
    'uses' => 'ImagesController@showgallery'
));

Route::get('image/{username}/{filename}', 'ImagesController@displayimage')->name('image.displayimage');

