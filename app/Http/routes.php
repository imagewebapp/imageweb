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

Route::get('forgotpassword', array(
    'uses' => 'ImagesController@showforgotpassword'
));

Route::post('generatepasscode', array(
    'uses' => 'ImagesController@generatepasscode'
));

Route::get('changepassword', array(
    'uses' => 'ImagesController@showchangepassword'
));

Route::post('changepassword', array(
    'uses' => 'ImagesController@changepassword'
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

Route::get('downloadpopup', array(
    'uses' => 'ImagesController@showdownloadwin'
));

Route::get('gallery', array(
    'uses' => 'ImagesController@showgallery'
));

Route::get('verifyimagesiface', array(
    'uses' => 'ImagesController@verifyimagesiface'
));

Route::post('verifyimages', array(
    'uses' => 'ImagesController@verifyimages'
));

Route::post('changeprofileimage', array(
    'uses' => 'ImagesController@changeprofileimage'
));

Route::post('removeimage', array(
    'uses' => 'ImagesController@removeimage'
));

Route::get('aboutus', array(
    'uses' => 'ImagesController@showaboutus'
));

Route::get('termsandconditions', array(
    'uses' => 'ImagesController@showtermsandconditions'
));

Route::get('showcaptcha', array(
    'uses' => 'ImagesController@showcaptcha'
));

Route::post('handlecaptcha', array(
    'uses' => 'ImagesController@handlecaptcha'
));

Route::get('cardpayment', array(
    'uses' => 'ImagesController@cardpaymentbystripe'
));

Route::post('cardpayment', array(
    'uses' => 'ImagesController@makepaymentbystripe'
));

Route::get('paypalpayment', array(
    'uses' => 'ImagesController@paymentbypaypal'
));

Route::post('paypalpayment', array(
    'uses' => 'ImagesController@makepaymentbypaypal'
));
Route::get('image/{username}/{filename}', 'ImagesController@displayimage')->name('image.displayimage');
Route::get('image/{username}/profileimage/{filename}', 'ImagesController@displayprofileimage')->name('image.displayprofileimage');

