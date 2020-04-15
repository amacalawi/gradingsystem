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

    /* Departments */
    Route::get('departments/add', 'DepartmentsController@add')->name('departments.add');
    Route::get('departments/edit/{id?}', 'DepartmentsController@edit')->name('departments.edit');
    Route::post('departments/store', 'DepartmentsController@store')->name('departments.store');
    Route::put('departments/update/{id}', 'DepartmentsController@update')->name('departments.update');
    Route::get('departments', 'DepartmentsController@manage')->name('departments.manage.active');
    Route::get('departments/inactive', 'DepartmentsController@inactive')->name('departments.manage.inactive');
    Route::post('departments/remove', 'DepartmentsController@remove')->name('departments.remove');
    Route::post('departments/restore', 'DepartmentsController@restore')->name('departments.restore');
    Route::get('departments/all-active', 'DepartmentsController@all_active')->name('departments.all.active');
    Route::get('departments/all-inactive', 'DepartmentsController@all_inactive')->name('departments.all.inactive');
    Route::put('departments/update-status/{id}', 'DepartmentsController@update_status')->name('departments.update.status');
    /* End Departments Routes */

    /* Designations */
    Route::get('designations/add', 'DesignationsController@add')->name('designations.add');
    Route::get('designations/edit/{id?}', 'DesignationsController@edit')->name('designations.edit');
    Route::post('designations/store', 'DesignationsController@store')->name('designations.store');
    Route::put('designations/update/{id}', 'DesignationsController@update')->name('designations.update');
    Route::get('designations', 'DesignationsController@manage')->name('designations.manage.active');
    Route::get('designations/inactive', 'DesignationsController@inactive')->name('designations.manage.inactive');
    Route::post('designations/remove', 'DesignationsController@remove')->name('designations.remove');
    Route::post('designations/restore', 'DesignationsController@restore')->name('designations.restore');
    Route::get('designations/all-active', 'DesignationsController@all_active')->name('designations.all.active');
    Route::get('designations/all-inactive', 'DesignationsController@all_inactive')->name('designations.all.inactive');
    Route::put('designations/update-status/{id}', 'DesignationsController@update_status')->name('designations.update.status');
    /* End Designations Routes */
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