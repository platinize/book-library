<?php


//Route::get('/', function () {
//    return view('library');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home', 'UserController@updatePhoto')->name('setPhoto');
Route::get('/home/delete-photo', 'UserController@defaultPhoto')->name('deletePhoto');
Route::any('/', 'BookController@index')->name('library');
Route::get('/library/book/{id}', 'BookController@show')->name('showBook');
Route::any('/library/{genreId}', 'BookController@groupByGenre')->name('groupByGenre');
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/enter', 'HomeController@admin')->name('enter');
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::get('/admin/books/{column}/{order}', 'BookController@indexAdmin')->name('booksAdmin');
    Route::post('/admin/books/{column}/{order}', 'BookController@serchIndex')->name('serchIndex');
    Route::get('/admin/create-book', 'BookController@create')->name('createBook');
    Route::post('/admin/create-book', 'BookController@store');
    Route::get('/admin/edit-book/{id}', 'BookController@edit')->name('editBook');
    Route::post('/admin/edit-book/{id}', 'BookController@update')->name('updateBook');
    Route::post('/admin/delete-book/{id}', 'BookController@destroy')->name('deleteBook');
    Route::get('/admin/users/{role}', 'UserController@index')->name('users');
    Route::post('/admin/users/{role}', 'UserController@serchUser')->name('usersSearch');
    Route::any('/admin/users/delete/{id}', 'UserController@destroy')->name('deleteUser');
    Route::get('/admin/users/edit/{id}', 'UserController@edit')->name('editUser');
    Route::post('/admin/users/edit/{id}', 'UserController@update')->name('updateUser');
    Route::get('/admin/users/user/create', 'UserController@create')->name('createUser');
    Route::post('/admin/users/user/create', 'UserController@store')->name('storeUser');
    Route::get('/admin/users/user/profile/{id}', 'UserController@show')->name('showUser');
    Route::any('/admin/users/user/profile/bookUser/delete/{id}', 'BookUserController@destroy')->name('destroyBookUser');
    Route::get('/admin/taken-books', 'BookUserController@index')->name('taken');
    Route::get('/admin/create-taken-books/{userId}', 'BookUserController@create')->name('createBookUser');
    Route::post('/admin/create-taken-books/{userId}', 'BookUserController@createSearch')->name('createSearchBookUser');
    Route::post('/admin/store-taken-books', 'BookUserController@store')->name('storeBookUser');
    Route::get('/admin/books/genres', 'GenresController@index')->name('genresAdmin');
    Route::get('/admin/books/genres/delete/{id}', 'GenresController@destroy')->name('deleteGenre');
    Route::post('/admin/books/genres-create', 'GenresController@store')->name('storeGenre');
    Route::any('/admin/books/genres/genres-update/{id}', 'GenresController@update')->name('updateGenre');
    Route::get('/admin/messege', 'AdminController@mailForm')->name('mailForm');
    Route::post('/admin/messege', 'MailSetting@sendMail')->name('sendMail');
});
