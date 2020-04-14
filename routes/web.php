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

use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('schools')->group(function () {
    /* Batches */
    Route::get('batches/add', 'BatchesController@add')->name('batches.add');
    Route::get('batches/edit/{id?}', 'BatchesController@edit')->name('batches.edit');
    Route::post('batches/store', 'BatchesController@store')->name('batches.store');
    Route::put('batches/update/{id}', 'BatchesController@update')->name('batches.update');
    Route::get('batches', 'BatchesController@manage')->name('batches.manage.active');
    Route::get('batches/inactive', 'BatchesController@inactive')->name('batches.manage.inactive');
    Route::post('batches/remove', 'BatchesController@remove')->name('batches.remove');
    Route::post('batches/restore', 'BatchesController@restore')->name('batches.restore');
    Route::get('batches/all-active', 'BatchesController@all_active')->name('batches.all.active');
    Route::get('batches/all-inactive', 'BatchesController@all_inactive')->name('batches.all.inactive');
    Route::put('batches/update-status/{id}', 'BatchesController@update_status')->name('batches.update.status');
    /* End Batches Routes */

    /* Batches */
    Route::get('quarters/add', 'QuartersController@add')->name('quarters.add');
    Route::get('quarters/edit/{id?}', 'QuartersController@edit')->name('quarters.edit');
    Route::post('quarters/store', 'QuartersController@store')->name('quarters.store');
    Route::put('quarters/update/{id}', 'QuartersController@update')->name('quarters.update');
    Route::get('quarters', 'QuartersController@manage')->name('quarters.manage.active');
    Route::get('quarters/inactive', 'QuartersController@inactive')->name('quarters.manage.inactive');
    Route::post('quarters/remove', 'QuartersController@remove')->name('quarters.remove');
    Route::post('quarters/restore', 'QuartersController@restore')->name('quarters.restore');
    Route::get('quarters/all-active', 'QuartersController@all_active')->name('quarters.all.active');
    Route::get('quarters/all-inactive', 'QuartersController@all_inactive')->name('quarters.all.inactive');
    Route::put('quarters/update-status/{id}', 'QuartersController@update_status')->name('quarters.update.status');
    /* End Batches Routes */
});

Route::prefix('memberships')->group(function () {
    Route::get('students/add', 'StudentsController@add')->name('students.add');
    Route::get('students/edit/{id?}', 'StudentsController@edit')->name('students.edit');
    Route::post('students/store', 'StudentsController@store')->name('students.store');
    Route::put('students/update/{id}', 'StudentsController@update')->name('students.update');
});


Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/send-mail', function () {
    Mail::to('aranfure@gmail.com')->send(new UserNotification()); 
    return 'A message has been sent to Mailtrap!';
});