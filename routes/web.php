<?php
use App\Person;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PersonController@index')->middleware('auth');

Auth::routes();

Route::delete('/person/{id}', function ($id) {
    Person::findOrFail($id)->delete();

    return redirect('/');
})->middleware('auth');

Route::resource('person', 'PersonController');

Route::get('/home', 'PersonController@index')->middleware('auth');

Route::post('/person/store',[
    'as' => 'person.store',
    'uses' => 'PersonController@store'
])->middleware('auth');


