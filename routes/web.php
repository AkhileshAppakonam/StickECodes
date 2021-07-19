<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', 'PagesController@welcome');

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::get('/codes/{codeId}/editPage', 'CodesController@show');
Route::get('/securityProfilePage', 'SecurityProfilesController@index');
Route::get('/securityProfilePage/edit', 'SecurityProfilesController@edit');

// Form Requests
Route::post('/codes/{codeId}/editPage', 'CodesController@edit');