<?php


//Homepage
Route::get('/', 'App\controllers\HomeController@index')->name('home.index');
Route::get('/home/show/{id}', 'App\controllers\HomeController@show')->name('home.show');


//Course (list & show)
Route::get('/courses', 'App\controllers\CourseController@index')->name('course.index');
Route::get('/course/show/{id}', 'App\controllers\CourseController@show')->name('course.show');

//Course play
Route::post('/course/play/post', 'App\controllers\CourseController@play')->name('course.play');
Route::get('/course/play/course/{id}', 'App\controllers\CourseController@playshow')->name('course.show.play');


//Commentaires Course
Route::post('/course/comment/create', 'App\controllers\CommentController@create')->name('course.comment.create');
Route::get('/course/comment/delete/{idComment}/{idCourse}', 'App\controllers\CommentController@delete')->name('course.comment.delete');


//User security
Route::get('/connection','App\controllers\UserController@connect')->name('user.connect') ;
Route::post('/login','App\controllers\UserController@login')->name('user.login') ;
Route::get('/logout','App\controllers\UserController@logout')->name('user.logout') ;

Route::get('/register','App\controllers\UserController@register')->name('user.register') ;
Route::post('/new/user','App\controllers\UserController@create')->name('user.create') ;

Route::get('/password_forget', 'App\controllers\UserController@index')->name('user.password');
Route::post('/password_forget/post', 'App\controllers\UserController@password')->name('user.send');


//User:account:profile
Route::get('/account/profile','App\controllers\Account\AccountProfileController@index')->name('account.profile.index') ;


//User:account:course
Route::get('/account/courses/','App\controllers\Account\AccountCourseController@index')->name('account.course.index') ;
Route::get('/account/courses/list/','App\controllers\Account\AccountCourseController@list')->name('account.course.list') ;
Route::get('/account/course/delete/{id}','App\controllers\Account\AccountCourseController@delete')->name('account.course.delete') ;
Route::get('/account/course/create','App\controllers\Account\AccountCourseController@createForm')->name('account.course.create') ;
Route::post('/account/course/new','App\controllers\Account\AccountCourseController@create')->name('account.course.new') ;
Route::get('/account/course/show/{id}','App\controllers\Account\AccountCourseController@show')->name('account.course.show') ;


//User:account:location
Route::get('/account/course/{id}/location/create','App\controllers\Account\AccountLocationController@createForm')->name('account.location.create') ;
Route::post('/account/location/new','App\controllers\Account\AccountLocationController@create')->name('account.location.new') ;

//User:account:riddle
Route::get('/account/location/{id}/riddle/create','App\controllers\Account\AccountRiddleController@createForm')->name('account.riddle.create') ;
Route::post('/account/riddle/new','App\controllers\Account\AccountRiddleController@create')->name('account.riddle.new') ;

//User:account:clue
Route::get('/account/riddle/{id}/clue/create','App\controllers\Account\AccountClueController@createForm')->name('account.clue.create') ;
Route::post('/account/clue/new','App\controllers\Account\AccountClueController@create')->name('account.clue.new') ;


//Admin:account:admin:user
Route::get('/account/admin/users/','App\controllers\Account\Admin\AdminUserController@index')->name('admin.user.index') ;
Route::get('/account/admin/users/show/{emailUser}','App\controllers\Account\Admin\AdminUserController@show')->name('admin.user.show') ;
Route::get('/account/admin/users/delete/{emailUser}','App\controllers\Account\Admin\AdminUserController@delete')->name('admin.user.delete') ;
Route::post('/account/admin/users/edit/{emailUser}','App\controllers\Account\Admin\AdminUserController@edit')->name('admin.user.edit') ;


//Admin:account:admin:course
Route::get('/account/admin/courses/','App\controllers\Account\Admin\AdminCourseController@index')->name('admin.course.index') ;
Route::get('/account/admin/courses/show/{id}','App\controllers\Account\Admin\AdminCourseController@show')->name('admin.course.show') ;
Route::get('/account/admin/courses/delete/{id}','App\controllers\Account\Admin\AdminCourseController@delete')->name('admin.course.delete') ;
Route::get('/account/admin/courses/edit/{id}','App\controllers\Account\Admin\AdminCourseController@edit')->name('admin.course.edit') ;


//contact
Route::get('/contact', 'App\controllers\ContactController@index')->name('contact.index');
Route::post('/contact/post', 'App\controllers\ContactController@send')->name('contact.send');


//About
Route::get('/about', 'App\controllers\AboutController@index')->name('about.index');
//StopWatch test
Route::get('/stopwatch', 'App\controllers\StopwatchController@index')->name('stopwatch.index');


//Riddle API
Route::get('/userlist', 'App\controllers\API\RiddleApi@index');