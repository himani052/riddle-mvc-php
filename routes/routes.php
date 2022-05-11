<?php



Route::get('/', 'App\controllers\HomeController@index')->name('home.index');
//Route::get('/', 'App\controllers\DefaultController@index');
Route::get('/home/show/{id}', 'App\controllers\HomeController@show')->name('home.show');
Route::post('/home/create', 'App\controllers\HomeController@create')->name('home.create');


//Parcours
Route::get('/parcours', 'App\controllers\ParcoursController@index')->name('parcours.index');
Route::get('/parcours/show/{id}', 'App\controllers\ParcoursController@show')->name('parcours.show');


//Commentaires Parcours
Route::post('/parcours/comment/create', 'App\controllers\CommentController@create')->name('parcours.comment.create');
Route::get('/parcours/comment/delete/{id}/{parcoursID}', 'App\controllers\CommentController@delete')->name('parcours.comment.delete');





//Admin
//Route::get('/admin','App\controllers\Admin\SecurityController@connect')->name('admin.connect') ;
//Route::post('/admin/login','App\controllers\Admin\SecurityController@login')->name('admin.login') ;
//Route::get('/admin/logout','App\controllers\Admin\SecurityController@logout')->name('admin.logout') ;
Route::get('/admin/dashboard','App\controllers\Admin\DashboardController@index')->name('admin.dashboard') ;


//User
Route::get('/connection','App\controllers\UserController@connect')->name('user.connect') ;
Route::post('/login','App\controllers\UserController@login')->name('user.login') ;
Route::get('/logout','App\controllers\UserController@logout')->name('user.logout') ;

Route::get('/inscription','App\controllers\UserController@register')->name('user.register') ;


//User:account:parcours
Route::get('/account/parcours/','App\controllers\Account\ParcoursController@index')->name('account.parcours.index') ;
Route::get('/account/parcours/list/','App\controllers\Account\ParcoursController@list')->name('account.parcours.list') ;







