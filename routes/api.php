<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* Login */
Route::post('/login', 'LoginController@login');

/* Logout */
Route::get('/logout', 'LoginController@logout');

/* User logged */
Route::get('/user-logged', 'LoginController@userLogged')->middleware('auth:api');