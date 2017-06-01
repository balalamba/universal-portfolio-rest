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

// Entrust + JWT
// Route to create a new role
Route::post('role', 'JwtAuthenticateController@createRole');
// Route to create a new permission
Route::post('permission', 'JwtAuthenticateController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'JwtAuthenticateController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'admin', 'middleware' => ['ability:admin,create-users']], function()
{
    // Protected route
    Route::get('users', 'JwtAuthenticateController@getAllUsers');
});

// Authentication route
Route::post('authenticate', 'JwtAuthenticateController@authenticate');
