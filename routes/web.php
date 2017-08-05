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

// Auth for login
Auth::routes();
Route::post('/login', 'LoginController@authenticate');

/*----------HOME CONTROLLER----------*/
Route::get('/home', 'HomeController@index');
Route::get('/add_family_member', 'HomeController@add_family_member');
Route::post('/add_family_member', 'HomeController@add_member');
Route::get('/shirts', 'HomeController@shirts');
Route::get('/points', 'HomeController@points');

/*----------PROFILE CONTROLLER----------*/
Route::get('/profile/{user}', 'ProfileController@index');
Route::post('/add_profile_picture', 'ProfileController@add_profile_picture');

/*----------TEAM CONTROLLER----------*/
Route::get('/teams', 'TeamsController@index');
Route::get('/teams2k2', 'TeamsController@team2k2');
Route::get('/team/{team}', 'TeamsController@team');

/*----------POST CONTROLLER----------*/
Route::get('/comments/{post}', 'PostController@comments');
Route::post('/post', 'PostController@post');
Route::post('/update_post', 'PostController@update_post');
Route::post('/add_comment', 'PostController@add_comment');

/*----------CALENDAR CONTROLLER----------*/
Route::get('/calendar', 'CalendarController@index');
