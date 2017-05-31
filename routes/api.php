<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user',[
	'uses' => 'userController@signup'
]);
Route::post('/user/signin',[
	'uses' => 'userController@signin'
]);
Route::post('/blog',[
	'uses' => 'blogController@addBlog',
	'middleware' => 'auth.jwt'
]);
Route::get('/blog',[
	'uses' => 'blogController@getBlog'
]);
Route::put('/blog/{id}',[
	'uses' => 'blogController@putBlog',
	'middleware' => 'auth.jwt'
]);
Route::delete('/blog/{id}',[
	'uses' => 'blogController@deleteBlog',
	'middleware' => 'auth.jwt'
]);

Route::get('/admin/users',[
	'uses' => 'adminController@allUsers',
	'middleware' => 'auth.jwt'
]);