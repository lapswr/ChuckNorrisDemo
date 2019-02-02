<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@emailsForm');
Route::get('/emails/listing', function () {
    return redirect('/');
});
Route::post('/emails/listing', 'IndexController@emailsListing');
Route::post('/send/email', 'IndexController@sendEmail');