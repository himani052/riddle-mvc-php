<?php



Route::get('/', 'App\controllers\HomeController@index')->name('home.index');
//Route::get('/', 'App\controllers\DefaultController@index');
Route::get('/home/show/{id}', 'App\controllers\HomeController@show')->name('home.show');
Route::post('/home/create', 'App\controllers\HomeController@create')->name('home.create');


//Course
Route::get('/course', 'App\controllers\CourseController@index')->name('course.index');
Route::get('/course/show/{id}', 'App\controllers\CourseController@show')->name('course.show');


//Commentaires Course
Route::post('/course/comment/create', 'App\controllers\CommentController@create')->name('course.comment.create');
Route::get('/course/comment/delete/{idComment}/{idCourse}', 'App\controllers\CommentController@delete')->name('course.comment.delete');



//Admin
//Route::get('/admin','App\controllers\Admin\SecurityController@connect')->name('admin.connect') ;
//Route::post('/admin/login','App\controllers\Admin\SecurityController@login')->name('admin.login') ;
//Route::get('/admin/logout','App\controllers\Admin\SecurityController@logout')->name('admin.logout') ;
Route::get('/admin/dashboard','App\controllers\Admin\DashboardController@index')->name('admin.dashboard') ;


//User
Route::get('/connection','App\controllers\UserController@connect')->name('user.connect') ;
Route::post('/login','App\controllers\UserController@login')->name('user.login') ;
Route::get('/logout','App\controllers\UserController@logout')->name('user.logout') ;

Route::get('/register','App\controllers\UserController@register')->name('user.register') ;
Route::post('/new/user','App\controllers\UserController@create')->name('user.create') ;


//User:account:course
Route::get('/account/courses/','App\controllers\Account\AccountCourseController@index')->name('account.course.index') ;
Route::get('/account/courses/list/','App\controllers\Account\AccountCourseController@list')->name('account.course.list') ;
Route::get('/account/course/delete/{id}','App\controllers\Account\AccountCourseController@delete')->name('account.course.delete') ;
Route::get('/account/course/create','App\controllers\Account\AccountCourseController@createForm')->name('account.course.create') ;
Route::post('/account/course/new','App\controllers\Account\AccountCourseController@create')->name('account.course.new') ;


//User:account:admin:users
Route::get('/account/admin/users/','App\controllers\Account\Admin\AdminUserController@index')->name('admin.user.index') ;

//contact
Route::get('/contact', 'App\controllers\ContactController@index')->name('contact.index');
Route::post('/contact/post', 'App\controllers\ContactController@send')->name('contact.send');







