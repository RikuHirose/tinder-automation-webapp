<?php

Route::group(['as' => 'api.', 'namespace' => 'Api'], function() {
  Route::group(['prefix' => 'v1', 'as' => 'v1.', 'namespace' => 'V1'], function() {

    // Route::group(['middleware' => 'api.auth'], function() {
    Route::group([], function() {
      Route::group(['prefix' => 'users', 'as' => 'users.'],
        function () {
          Route::post('/integrate', 'UserController@integrate')->name('integrate');
          Route::post('/swipe', 'UserController@swipe')->name('swipe');
      });

    });

  });
});
