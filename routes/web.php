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
    Route::post('students/uploads', 'StudentsController@uploads')->name('students.uploads');
    Route::get('students/downloads', 'StudentsController@downloads')->name('students.downloads');
    Route::get('students/get-all-siblings', 'StudentsController@get_all_siblings')->name('students.siblings');
    Route::get('students/add', 'StudentsController@add')->name('students.add');
    Route::get('students/edit/{id?}', 'StudentsController@edit')->name('students.edit');
    Route::post('students/store', 'StudentsController@store')->name('students.store');
    Route::put('students/update/{id}', 'StudentsController@update')->name('students.update');
    Route::get('students', 'StudentsController@manage')->name('students.manage.active');
    Route::get('students/inactive', 'StudentsController@inactive')->name('students.manage.inactive');
    Route::post('students/remove', 'StudentsController@remove')->name('students.remove');
    Route::post('students/restore', 'StudentsController@restore')->name('students.restore');
    Route::get('students/all-active', 'StudentsController@all_active')->name('students.all.active');
    Route::get('students/all-inactive', 'StudentsController@all_inactive')->name('students.all.inactive');
    Route::put('students/update-status/{id}', 'StudentsController@update_status')->name('students.update.status');

    /* Staffs */
    Route::post('staffs/uploads', 'StaffsController@uploads')->name('staffs.uploads');
    Route::get('staffs/downloads', 'StaffsController@downloads')->name('staffs.downloads');
    Route::get('staffs/add', 'StaffsController@add')->name('staffs.add');
    Route::get('staffs/edit/{id?}', 'StaffsController@edit')->name('staffs.edit');
    Route::post('staffs/store', 'StaffsController@store')->name('staffs.store');
    Route::put('staffs/update/{id}', 'StaffsController@update')->name('staffs.update');
    Route::get('staffs', 'StaffsController@manage')->name('staffs.manage.active');
    Route::get('staffs/inactive', 'StaffsController@inactive')->name('staffs.manage.inactive');
    Route::post('staffs/remove', 'StaffsController@remove')->name('staffs.remove');
    Route::post('staffs/restore', 'StaffsController@restore')->name('staffs.restore');
    Route::get('staffs/all-active', 'StaffsController@all_active')->name('staffs.all.active');
    Route::get('staffs/all-inactive', 'StaffsController@all_inactive')->name('staffs.all.inactive');
    Route::put('staffs/update-status/{id}', 'StaffsController@update_status')->name('staffs.update.status');
    /* End Staffs Routes */
});


Route::prefix('academics')->group(function () {
    /* Sections */
    Route::get('sections/add', 'SectionsController@add')->name('sections.add');
    Route::get('sections/edit/{id?}', 'SectionsController@edit')->name('sections.edit');
    Route::post('sections/store', 'SectionsController@store')->name('sections.store');
    Route::put('sections/update/{id}', 'SectionsController@update')->name('sections.update');
    Route::get('sections', 'SectionsController@manage')->name('sections.manage.active');
    Route::get('sections/inactive', 'SectionsController@inactive')->name('sections.manage.inactive');
    Route::post('sections/remove', 'SectionsController@remove')->name('sections.remove');
    Route::post('sections/restore', 'SectionsController@restore')->name('sections.restore');
    Route::get('sections/all-active', 'SectionsController@all_active')->name('sections.all.active');
    Route::get('sections/all-inactive', 'SectionsController@all_inactive')->name('sections.all.inactive');
    Route::put('sections/update-status/{id}', 'SectionsController@update_status')->name('sections.update.status');
    /* End Sections Routes */

    /* Levels */
    Route::get('levels/add', 'LevelsController@add')->name('levels.add');
    Route::get('levels/edit/{id?}', 'LevelsController@edit')->name('levels.edit');
    Route::post('levels/store', 'LevelsController@store')->name('levels.store');
    Route::put('levels/update/{id}', 'LevelsController@update')->name('levels.update');
    Route::get('levels', 'LevelsController@manage')->name('levels.manage.active');
    Route::get('levels/inactive', 'LevelsController@inactive')->name('levels.manage.inactive');
    Route::post('levels/remove', 'LevelsController@remove')->name('levels.remove');
    Route::post('levels/restore', 'LevelsController@restore')->name('levels.restore');
    Route::get('levels/all-active', 'LevelsController@all_active')->name('levels.all.active');
    Route::get('levels/all-inactive', 'LevelsController@all_inactive')->name('levels.all.inactive');
    Route::put('levels/update-status/{id}', 'LevelsController@update_status')->name('levels.update.status');
    /* End Levels Routes */

    /* Subjects */
    Route::get('subjects/add', 'SubjectsController@add')->name('subjects.add');
    Route::get('subjects/edit/{id?}', 'SubjectsController@edit')->name('subjects.edit');
    Route::post('subjects/store', 'SubjectsController@store')->name('subjects.store');
    Route::put('subjects/update/{id}', 'SubjectsController@update')->name('subjects.update');
    Route::get('subjects', 'SubjectsController@manage')->name('subjects.manage.active');
    Route::get('subjects/inactive', 'SubjectsController@inactive')->name('subjects.manage.inactive');
    Route::post('subjects/remove', 'SubjectsController@remove')->name('subjects.remove');
    Route::post('subjects/restore', 'SubjectsController@restore')->name('subjects.restore');
    Route::get('subjects/all-active', 'SubjectsController@all_active')->name('subjects.all.active');
    Route::get('subjects/all-inactive', 'SubjectsController@all_inactive')->name('subjects.all.inactive');
    Route::put('subjects/update-status/{id}', 'SubjectsController@update_status')->name('subjects.update.status');
    //Route::get('students/get-all-siblings', 'StudentsController@get_all_siblings')->name('students.siblings');
    Route::get('subjects/get-all-subjects', 'SubjectsController@get_all_subjects');
    Route::get('subjects/get-all-teachers', 'SubjectsController@get_all_teachers'); 
    /* End Subjects Routes */
});



Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/send-mail', function () {
    Mail::to('aranfure@gmail.com')->send(new UserNotification()); 
    return 'A message has been sent to Mailtrap!';
});