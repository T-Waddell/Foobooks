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

//original
/*
Route::get('/', function () {
    #return view('abc');
    return view('welcome');
});
*/
Route::get('/', 'WelcomeController');

//with multiple parameters, they correspond with the variables passed to the closure function in the order they appear in the URI.
/*Route::get('/books/{category}/{title}', function ($category, $title) {
    return 'You are viewing the book: '.$title.' in the category '.$category;
}); */

//? makes the URL optional. method 1
/*Route::get('/books/{title?}', function ($title = null) {
    if($title == null) {
        return "You did not specify a title.";
    }
    else {
        return 'You are viewing the book: '.$title;
    }
});
*/

//By coding a specific action for the /books route with no title, we no longer need
//to make the title optional.
//original method, replaced by the controller below:
/*Route::get('/books/{title}', function ($title) {
        return 'You are viewing the book: '.$title;
});
*/
Route::get('/books/{title}', 'BookController@show');

//original method. replaced by the controller below:
/*Route::get('/books', function () {
    return 'Here are all the books...';
});
*/

//second thing we pass in is a string of the controller and the method within it that we want to invoke.
Route::get('/books', 'BookController@index');

/**
 * Practice
 */
Route::any('/practice/{n?}', 'PracticeController@index');