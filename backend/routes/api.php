<?php

Route::post('/login', 'AuthController@login');
Route::get('/data', 'DataController@getData');