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

// Auth Group
Route::group(['prefix' => 'auth', 'as' => 'auth::'], function () {
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/profile', 'AuthController@profile')->name('profile')->middleware('jwt.auth');
  
    //Just for generate password
    Route::get('/password', function (Request $request) {
      return Hash::make($request->password);
    });
  });

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::prefix('user')->group(function () {
      Route::get('/alluser', 'UserController@all');
      Route::get('/{id}', 'UserController@userById');
    });
    Route::prefix('ticket')->group(function () {
        Route::get('/allticket', 'TicketController@all');
        Route::get('/{id}', 'TicketController@ticketById');    
        Route::post('/save', 'TicketController@save');
    });
  });