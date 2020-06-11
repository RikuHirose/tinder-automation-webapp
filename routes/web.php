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


Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

  Route::group(['prefix' => 'mypage/', 'as' => 'mypage.'], function () {
      Route::get('/', 'User\MypageController@show')->name('show');
      Route::get('/edit', 'User\MypageController@edit')->name('edit');
      Route::post('/update', 'User\MypageController@update')->name('update');

      // Route::get('/favorited', 'User\MypageController@showFavorited')->name('favorited');

      Route::get('/password', 'User\MypageController@editPassword')->name('edit.password');
      Route::post('/password', 'User\MypageController@updatePassword')->name('update.password');

      //     Route::get('/{user}/reviewed', 'User\UserController@showReviewed')->name('show.reviewed');
      //     Route::get('/{user}/history', 'User\UserController@showHistory')->name('show.history');

      //     Route::get('setting/{user}', 'User\UserController@getSetting')->name('setting.get');
      //     Route::post('setting/{user}', 'User\UserController@postSetting')->name('setting.post');
  });

});

