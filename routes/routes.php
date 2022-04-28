<?php



Route::get('/', 'App\controllers\HomeController@index')->name('home.index');
//Route::get('/', 'App\controllers\DefaultController@index');
Route::get('/home/show/{id}', 'App\controllers\HomeController@show')->name('home.show');
Route::post('/home/create', 'App\controllers\HomeController@create')->name('home.create');


//Parcours
Route::get('/parcours', 'App\controllers\ParcoursController@index')->name('parcours.index');
Route::get('/parcours/show/{id}', 'App\controllers\ParcoursController@show')->name('parcours.show');


//Admin

Route::get('/admin','App\controllers\Admin\SecurityController@connect')->name('admin.connect') ;
Route::post('/admin/login','App\controllers\Admin\SecurityController@login')->name('admin.login') ;

Route::get('/admin/dashboard','App\controllers\Admin\DashboardController@index')->name('admin.dashboard') ;



Route::post('/admin/test','App\controllers\DefaultController@traitement')->name('home.test') ;
