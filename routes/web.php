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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('users', 'HomeController@users')->name('users');
Route::get('branches', 'HomeController@branches')->name('branches');
Route::get('reports', 'HomeController@reports')->name('reports');



Route::post('edituser', 'HomeController@edituser')->name('edituser');
Route::post('/newuser', 'HomeController@newuser')->name('newuser');
Route::post('/updateuser', 'HomeController@updateuser')->name('updateuser');
Route::post('/delusr', 'HomeController@delusr')->name('delusr');
Route::post('readfile', 'HomeController@readfile')->name('readfile');

Route::post('branchdetail', 'HomeController@managebranch')->name('managebranch');
Route::get('products/{id}', 'HomeController@getpros')->name('getpros');

Route::post('/newbranch', 'HomeController@newbranch')->name('newbranch');
Route::post('editbranch', 'HomeController@editbranch')->name('editbranch');
Route::post('/updatebranch', 'HomeController@updatebranch')->name('updatebranch');


Route::post('/newproduct', 'HomeController@newproduct')->name('newproduct');
Route::post('editproduct', 'HomeController@editproduct')->name('editproduct');
Route::post('/updateproduct', 'HomeController@updateproduct')->name('updateproduct');
Route::post('/delproduct', 'HomeController@delproduct')->name('delproduct');

Route::get('/pdfview','HomeController@pdfview');


Route::post('/delreport', 'HomeController@delreport')->name('delreport');





