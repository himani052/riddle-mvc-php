<?php



Route::get('/', 'App\controllers\HomeController@index')->name('home.index');
//Route::get('/', 'App\controllers\DefaultController@index');
Route::get('/home/show/{id}', 'App\controllers\HomeController@show')->name('home.show');
Route::post('/home/create', 'App\controllers\HomeController@create')->name('home.create');


//Parcours
Route::get('/parcours', 'App\controllers\ParcoursController@index')->name('parcours.index');
Route::get('/parcours/show/{id}', 'App\controllers\ParcoursController@show')->name('parcours.show');


