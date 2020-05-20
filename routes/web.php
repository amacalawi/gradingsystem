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

Route::prefix('components')->group(function () {
    /* Schools Routes */
    Route::prefix('schools')->group(function () {
        /* Start Batches Routes */
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

        /* Start Quarters Routes */
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
        /* End Quarters Routes */

        /* Start Departments Routes */
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

        /* Start Designations Routes */
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
    /* End Schools Routes */

    /* Menus Routes */
    Route::prefix('menus')->group(function () {
        /* Start Headers Routes */
        Route::get('headers/add', 'HeadersController@add')->name('menus.headers.add');
        Route::get('headers/edit/{id?}', 'HeadersController@edit')->name('menus.headers.edit');
        Route::post('headers/store', 'HeadersController@store')->name('menus.headers.store');
        Route::put('headers/update/{id}', 'HeadersController@update')->name('menus.headers.update');
        Route::get('headers', 'HeadersController@manage')->name('menus.headers.manage.active');
        Route::get('headers/inactive', 'HeadersController@inactive')->name('menus.headers.manage.inactive');
        Route::post('headers/remove', 'HeadersController@remove')->name('menus.headers.remove');
        Route::post('headers/restore', 'HeadersController@restore')->name('menus.headers.restore');
        Route::get('headers/all-active', 'HeadersController@all_active')->name('menus.headers.all.active');
        Route::get('headers/all-inactive', 'HeadersController@all_inactive')->name('menus.headers.all.inactive');
        Route::put('headers/update-status/{id}', 'HeadersController@update_status')->name('menus.headers.update.status');
        /* End Headers Routes */

        /* Start Modules Routes */
        Route::get('modules/add', 'ModulesController@add')->name('menus.modules.add');
        Route::get('modules/edit/{id?}', 'ModulesController@edit')->name('menus.modules.edit');
        Route::post('modules/store', 'ModulesController@store')->name('menus.modules.store');
        Route::put('modules/update/{id}', 'ModulesController@update')->name('menus.modules.update');
        Route::get('modules', 'ModulesController@manage')->name('menus.modules.manage.active');
        Route::get('modules/inactive', 'ModulesController@inactive')->name('menus.modules.manage.inactive');
        Route::post('modules/remove', 'ModulesController@remove')->name('menus.modules.remove');
        Route::post('modules/restore', 'ModulesController@restore')->name('menus.modules.restore');
        Route::get('modules/all-active', 'ModulesController@all_active')->name('menus.modules.all.active');
        Route::get('modules/all-inactive', 'ModulesController@all_inactive')->name('menus.modules.all.inactive');
        Route::put('modules/update-status/{id}', 'ModulesController@update_status')->name('menus.modules.update.status');
        /* End Modules Routes */

        /* Start Sub Modules Routes */
        Route::get('sub-modules/add', 'SubModulesController@add')->name('menus.sub-modules.add');
        Route::get('sub-modules/edit/{id?}', 'SubModulesController@edit')->name('menus.sub-modules.edit');
        Route::post('sub-modules/store', 'SubModulesController@store')->name('menus.sub-modules.store');
        Route::put('sub-modules/update/{id}', 'SubModulesController@update')->name('menus.sub-modules.update');
        Route::get('sub-modules', 'SubModulesController@manage')->name('menus.sub-modules.manage.active');
        Route::get('sub-modules/inactive', 'SubModulesController@inactive')->name('menus.sub-modules.manage.inactive');
        Route::post('sub-modules/remove', 'SubModulesController@remove')->name('menus.sub-modules.remove');
        Route::post('sub-modules/restore', 'SubModulesController@restore')->name('menus.sub-modules.restore');
        Route::get('sub-modules/all-active', 'SubModulesController@all_active')->name('menus.sub-modules.all.active');
        Route::get('sub-modules/all-inactive', 'SubModulesController@all_inactive')->name('menus.sub-modules.all.inactive');
        Route::put('sub-modules/update-status/{id}', 'SubModulesController@update_status')->name('menus.sub-modules.update.status');
        /* End Sub Modules Routes */
    });
    /* End Menus Routes */
    
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

    /* User Accounts */
    Route::get('users/accounts/add', 'UserAccountsController@add')->name('users.accounts.add');
    Route::get('users/accounts/edit/{id?}', 'UserAccountsController@edit')->name('users.accounts.edit');
    Route::post('users/accounts/store', 'UserAccountsController@store')->name('users.accounts.store');
    Route::put('users/accounts/update/{id}', 'UserAccountsController@update')->name('users.accounts.update');
    Route::get('users/accounts', 'UserAccountsController@manage')->name('users.accounts.manage.active');
    Route::get('users/accounts/inactive', 'UserAccountsController@inactive')->name('users.accounts.manage.inactive');
    Route::post('users/accounts/remove', 'UserAccountsController@remove')->name('users.accounts.remove');
    Route::post('users/accounts/restore', 'UserAccountsController@restore')->name('users.accounts.restore');
    Route::get('users/accounts/all-active', 'UserAccountsController@all_active')->name('users.accounts.all.active');
    Route::get('users/accounts/all-inactive', 'UserAccountsController@all_inactive')->name('users.accounts.all.inactive');
    Route::put('users/accounts/update-status/{id}', 'UserAccountsController@update_status')->name('users.accounts.update.status');
    
    /* Roles and Permission */
    Route::get('users/roles/add', 'UserRoleController@add')->name('users.roles.add');
    Route::get('users/roles/edit/{id?}', 'UserRoleController@edit')->name('users.roles.edit');
    Route::post('users/roles/store', 'UserRoleController@store')->name('users.roles.store');
    Route::put('users/roles/update/{id}', 'UserRoleController@update')->name('users.roles.update');
    Route::get('users/roles', 'UserRoleController@manage')->name('users.roles.manage.active');
    Route::get('users/roles/inactive', 'UserRoleController@inactive')->name('users.roles.manage.inactive');
    Route::post('users/roles/remove', 'UserRoleController@remove')->name('users.roles.remove');
    Route::post('users/roles/restore', 'UserRoleController@restore')->name('users.roles.restore');
    Route::get('users/roles/all-active', 'UserRoleController@all_active')->name('users.roles.all.active');
    Route::get('users/roles/all-inactive', 'UserRoleController@all_inactive')->name('users.roles.all.inactive');
    Route::put('users/roles/update-status/{id}', 'UserRoleController@update_status')->name('users.roles.update.status');
});


Route::prefix('academics')->group(function () {

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
        Route::get('subjects/get-all-subjects', 'SubjectsController@get_all_subjects');
        Route::get('subjects/get-all-teachers', 'SubjectsController@get_all_teachers'); 
        /* End Subjects Routes */
    });

    /* Grading Sheets Routes */
    Route::prefix('admissions')->group(function () {  
        /* Admissions */
        Route::get('section-student/add', 'SectionsStudentsController@add')->name('sectionstudent.add');
        Route::get('section-student/edit/{id?}', 'SectionsStudentsController@edit')->name('sectionstudent.edit');
        Route::post('section-student/store', 'SectionsStudentsController@store')->name('sectionstudent.store');
        Route::put('section-student/update/{id}', 'SectionsStudentsController@update')->name('sectionstudent.update');
        Route::get('section-student', 'SectionsStudentsController@manage')->name('sectionstudent.manage.active');
        Route::get('section-student/inactive', 'SectionsStudentsController@inactive')->name('sectionstudent.manage.inactive');
        Route::post('section-student/remove', 'SectionsStudentsController@remove')->name('sectionstudent.remove');
        Route::post('section-student/restore', 'SectionsStudentsController@restore')->name('sectionstudent.restore');
        Route::get('section-student/all-active', 'SectionsStudentsController@all_active')->name('sectionstudent.all.active');
        Route::get('section-student/all-inactive', 'SectionsStudentsController@all_inactive')->name('sectionstudent.all.inactive');
        Route::put('section-student/update-status/{id}', 'SectionsStudentsController@update_status')->name('sectionstudent.update.status');        
        Route::get('section-student/all-admitted', 'AdmissionController@all_admitted')->name('admission.all.admitted');
        Route::get('section-student/get-this-admitted/{id?}', 'AdmissionController@get_this_admitted');
        /* End Admissions Routes */
    });

    /* Grading Sheets Routes */
    Route::prefix('grading-sheets')->group(function () {
        /* Start Grading Sheets Routes */
        Route::get('all-gradingsheets/add', 'GradingSheetsController@add')->name('gradingsheets.add');
        Route::get('all-gradingsheets/edit/{id?}', 'GradingSheetsController@edit')->name('gradingsheets.edit');
        Route::post('all-gradingsheets/store', 'GradingSheetsController@store')->name('gradingsheets.store');
        Route::put('all-gradingsheets/update/{id}', 'GradingSheetsController@update')->name('gradingsheets.update');
        Route::get('all-gradingsheets', 'GradingSheetsController@manage')->name('gradingsheets.manage.active');
        Route::get('all-gradingsheets/inactive', 'GradingSheetsController@inactive')->name('gradingsheets.manage.inactive');
        Route::post('all-gradingsheets/remove', 'GradingSheetsController@remove')->name('gradingsheets.remove');
        Route::post('all-gradingsheets/restore', 'GradingSheetsController@restore')->name('gradingsheets.restore');
        Route::get('all-gradingsheets/all-active', 'GradingSheetsController@all_active')->name('gradingsheets.all.active');
        Route::get('all-gradingsheets/all-inactive', 'GradingSheetsController@all_inactive')->name('gradingsheets.all.inactive');
        Route::put('all-gradingsheets/update-status/{id}', 'GradingSheetsController@update_status')->name('components.update.status');
        /* End Grading Sheets Routes */

        /* Start Components Routes */
        Route::get('components/add', 'ComponentsController@add')->name('components.add');
        Route::get('components/edit/{id?}', 'ComponentsController@edit')->name('components.edit');
        Route::post('components/store', 'ComponentsController@store')->name('components.store');
        Route::put('components/update/{id}', 'ComponentsController@update')->name('components.update');
        Route::get('components', 'ComponentsController@manage')->name('components.manage.active');
        Route::get('components/inactive', 'ComponentsController@inactive')->name('components.manage.inactive');
        Route::post('components/remove', 'ComponentsController@remove')->name('components.remove');
        Route::post('components/restore', 'ComponentsController@restore')->name('components.restore');
        Route::get('components/all-active', 'ComponentsController@all_active')->name('components.all.active');
        Route::get('components/all-inactive', 'ComponentsController@all_inactive')->name('components.all.inactive');
        Route::put('components/update-status/{id}', 'ComponentsController@update_status')->name('components.update.status');
        /* End Components Routes */


        
    });
    /* End Grading Sheets Routes */
});


Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/send-mail', function () {
    Mail::to('aranfure@gmail.com')->send(new UserNotification()); 
    return 'A message has been sent to Mailtrap!';
});