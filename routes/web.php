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
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::get('/welcome', 'PagesController@welcome');
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Route::get('/codes/lookUp', 'PagesController@codeLookUpView');

Route::get('/codes/{code}/editPage', 'CodesController@showEditPage');
Route::get('/viewPagesFile/{file}', 'CodesController@viewFile');
Route::get('/createCode','CodesController@create'); // Generating User QR Code Pages
Route::get('/pages/{userName}/{codeName}', 'CodesController@showPublicQRCodePage'); // Showing Public QR Code Pages


Route::get('/securityProfilePage', 'SecurityProfilesController@index');
Route::get('/securityProfilePage/{secProfile}/editSecurityProfile', 'SecurityProfilesController@show');
Route::get('/securityProfilePage/create', 'SecurityProfilesController@create');

// Form Requests
Route::post('/codes/{code}/{pageId}/editPage', 'CodesController@edit');
Route::post('/securityProfilePage/{secProfile}/editSecurityProfile', 'SecurityProfilesController@edit');
Route::post('/securityProfiles/deleteSecurityProfile', 'SecurityProfilesController@delete');
Route::post('/codes/lookUp', 'CodesController@codeLookUp');

// Permanent Redirects
// Route::permanentRedirect('/codes/{code}/{pageId}/editPage', '/public/index.php/dashboard');