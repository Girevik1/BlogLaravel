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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'digging_deeper'], function () {
    Route::get('collections','DiggingDeeperController@collection')
        ->name('digging_deeper.collections');
});

Route::group(['namespace' => 'BLog', 'prefix' => 'blog'], function () {
 Route::resource('posts', 'PostController')->names('blog.posts');
});

// Ajax
Route::any('/ajax', 'Blog\AjaxController@sendmail');

//Админка блога
$groupData = [
    'namespace' => 'Blog\Admin',
    'prefix' => 'admin/blog',
];
Route::group($groupData, function () {
    // BlogCategory
    $methods = ['index', 'edit', 'update', 'create', 'store',];
    Route::resource('categories','CategoryController')
        ->only($methods)
        ->names('blog.admin.categories');

    // BlogPost
    Route::resource('posts','PostController')
        ->except(['show']) // кроме одного метода - нам надо
        ->names('blog.admin.posts');
});




//Route::resource('rest', 'RestController')->names('restTest');
