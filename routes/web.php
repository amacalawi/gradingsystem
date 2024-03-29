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
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth/login');
});

Auth::routes();

Route::prefix('components')->group(function () {
    /* Schools Routes */
    Route::prefix('schools')->group(function () {
        /* Start Batches Routes */
        Route::get('schoolyears/add', 'BatchesController@add')->name('schoolyears.add');
        Route::get('schoolyears/edit/{id?}', 'BatchesController@edit')->name('schoolyears.edit');
        Route::post('schoolyears/store', 'BatchesController@store')->name('schoolyears.store');
        Route::put('schoolyears/update/{id}', 'BatchesController@update')->name('schoolyears.update');
        Route::get('schoolyears', 'BatchesController@manage')->name('schoolyears.manage.active');
        Route::get('schoolyears/inactive', 'BatchesController@inactive')->name('schoolyears.manage.inactive');
        Route::post('schoolyears/remove', 'BatchesController@remove')->name('schoolyears.remove');
        Route::post('schoolyears/restore', 'BatchesController@restore')->name('schoolyears.restore');
        Route::get('schoolyears/all-active', 'BatchesController@all_active')->name('schoolyears.all.active');
        Route::get('schoolyears/all-inactive', 'BatchesController@all_inactive')->name('schoolyears.all.inactive');
        Route::put('schoolyears/update-status/{id}', 'BatchesController@update_status')->name('schoolyears.update.status');
        /* End Batches Routes */

        /* Start Quarters Routes */
        Route::post('quarters/import', 'QuartersController@import')->name('quarters.import');
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
        Route::post('departments/import', 'DepartmentsController@import')->name('departments.import');
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
        Route::post('designations/import', 'DesignationsController@import')->name('designations.import');
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

        /* Start Education Type Routes */
        Route::get('education-types/add', 'EducationTypesController@add')->name('education-types.add');
        Route::get('education-types/edit/{id?}', 'EducationTypesController@edit')->name('education-types.edit');
        Route::post('education-types/store', 'EducationTypesController@store')->name('education-types.store');
        Route::put('education-types/update/{id}', 'EducationTypesController@update')->name('education-types.update');
        Route::get('education-types', 'EducationTypesController@manage')->name('education-types.manage.active');
        Route::get('education-types/inactive', 'EducationTypesController@inactive')->name('education-types.manage.inactive');
        Route::post('education-types/remove', 'EducationTypesController@remove')->name('education-types.remove');
        Route::post('education-types/restore', 'EducationTypesController@restore')->name('education-types.restore');
        Route::get('education-types/all-active', 'EducationTypesController@all_active')->name('education-types.all.active');
        Route::get('education-types/all-inactive', 'EducationTypesController@all_inactive')->name('education-types.all.inactive');
        Route::put('education-types/update-status/{id}', 'EducationTypesController@update_status')->name('education-types.update.status');
        /* End Education Type Routes */
    });
    /* End Schools Routes */

    /* Start Groups Routes */
    Route::get('groups', 'GroupsController@manage')->name('groups.manage.active');
    Route::get('groups/add', 'GroupsController@add')->name('groups.add');
    Route::get('groups/edit/{id?}', 'GroupsController@edit')->name('groups.edit');
    Route::post('groups/store', 'GroupsController@store')->name('groups.store');
    Route::put('groups/update/{id}', 'GroupsController@update')->name('groups.update');
    Route::put('groups/update-status/{id}', 'GroupsController@update_status')->name('groups.update.status');
    Route::post('groups/remove', 'GroupsController@remove')->name('groups.remove');
    Route::post('groups/restore', 'GroupsController@restore')->name('groups.restore');
    Route::get('groups/all-active', 'GroupsController@all_active')->name('groups.all.active');
    Route::get('groups/inactive', 'GroupsController@inactive')->name('groups.manage.inactive');
    Route::get('groups/all-inactive', 'GroupsController@all_inactive')->name('groups.all.inactive');
    Route::get('groups/group-user-list', 'GroupsController@all_group_users')->name('groups.all.group.users');
    Route::get('groups/all-member', 'GroupsController@all_member')->name('groups.all.member');    
    Route::get('groups/get-student/{id}', 'GroupsController@get_student')->name('groups.get.member');
    /* End Groups Routes */

    /* Start Schedules Routes */
    Route::get('schedules', 'SchedulesController@manage')->name('schedules.manage.active');
    Route::get('schedules/add', 'SchedulesController@add')->name('schedules.add');
    Route::get('schedules/edit/{id?}', 'SchedulesController@edit')->name('schedules.edit');
    Route::post('schedules/store', 'SchedulesController@store')->name('schedules.store');
    Route::put('schedules/update/{id}', 'SchedulesController@update')->name('schedules.update');
    Route::put('schedules/update-status/{id}', 'SchedulesController@update_status')->name('schedules.update.status');
    Route::post('schedules/remove', 'SchedulesController@remove')->name('schedules.remove');
    Route::post('schedules/restore', 'SchedulesController@restore')->name('schedules.restore');
    Route::get('schedules/all-active', 'SchedulesController@all_active')->name('schedules.all.active');
    Route::get('schedules/inactive', 'SchedulesController@inactive')->name('schedules.manage.inactive');
    Route::get('schedules/all-inactive', 'SchedulesController@all_inactive')->name('schedules.all.inactive');
    Route::get('schedules/all-member', 'SchedulesController@all_member')->name('schedules.all.member');
    Route::get('schedules/get-this-schedule/{id?}', 'SchedulesController@get_this_schedule');
    /* End Schedules Routes */

    /*Start Preset Message */
    Route::get('schedules/preset-message', 'PresetMessageController@manage')->name('presetmsg.manage.active');
    Route::get('schedules/preset-message/add', 'PresetMessageController@add')->name('presetmsg.add');
    Route::get('schedules/preset-message/edit/{id?}', 'PresetMessageController@edit')->name('presetmsg.edit');
    Route::post('schedules/preset-message/store', 'PresetMessageController@store')->name('presetmsg.store');
    Route::put('schedules/preset-message/update/{id}', 'PresetMessageController@update')->name('presetmsg.update');
    Route::put('schedules/preset-message/update-status/{id}', 'PresetMessageController@update_status')->name('presetmsg.update.status');
    Route::post('schedules/preset-message/remove', 'PresetMessageController@remove')->name('presetmsg.remove');
    Route::post('schedules/preset-message/restore', 'PresetMessageController@restore')->name('presetmsg.restore');
    Route::get('schedules/preset-message/all-active', 'PresetMessageController@all_active')->name('presetmsg.all.active');
    Route::get('schedules/preset-message/inactive', 'PresetMessageController@inactive')->name('presetmsg.manage.inactive');
    Route::get('schedules/preset-message/all-inactive', 'PresetMessageController@all_inactive')->name('presetmsg.all.inactive');
    /*End Preset Message */

    /* Start Calendars Routes */
    Route::get('calendars', 'CalendarsController@manage')->name('calendars.manage.active');
    Route::get('calendars/add', 'CalendarsController@add')->name('calendars.add');
    Route::get('calendars/edit/{id?}', 'CalendarsController@edit')->name('calendars.edit');
    Route::get('calendars/store', 'CalendarsController@store')->name('calendars.store');
    Route::put('calendars/update/{id}', 'CalendarsController@update')->name('calendars.update');
    Route::put('calendars/update-status/{id}', 'CalendarsController@update_status')->name('calendars.update.status');
    Route::get('calendars/remove/{id?}', 'CalendarsController@remove')->name('calendars.remove');
    Route::post('calendars/restore', 'CalendarsController@restore')->name('calendars.restore');
    Route::get('calendars/all-active', 'CalendarsController@all_active')->name('calendars.all.active');
    Route::get('calendars/inactive', 'CalendarsController@inactive')->name('calendars.manage.inactive');
    Route::get('calendars/all-inactive', 'CalendarsController@all_inactive')->name('calendars.all.inactive');
    Route::get('calendars/get-calendar', 'CalendarsController@get_calendar')->name('calendars.get.calendar');
    //Route::get('calendars/all-member', 'CalendarsController@all_member')->name('calendars.all.member');
    //Route::get('calendars/get-this-calendar/{id?}', 'CalendarsController@get_this_calendar');
    /* End Calendars Routes */
    
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

    /* CSV Management Routes */
    Route::prefix('csv-management')->group(function () {
        /* SOA Template 01 Routes */
        Route::post('soa-template-01/import', 'CsvTemplateSoaController@import')->name('csv_management.soa_template_01.import');
        Route::get('soa-template-01', 'CsvTemplateSoaController@index')->name('csv_management.soa_template_01.manage_active');
        Route::get('soa-template-01/inactive', 'CsvTemplateSoaController@inactive')->name('csv_management.soa_template_01.manage_inactive');
        Route::get('soa-template-01/all-active', 'CsvTemplateSoaController@all_active')->name('csv_management.soa_template_01.all_active');
        Route::get('soa-template-01/all-inactive', 'CsvTemplateSoaController@all_inactive')->name('csv_management.soa_template_01.all_inactive');
        Route::put('soa-template-01/update-status/{id}', 'CsvTemplateSoaController@update_status')->name('csv_management.soa_template_01.update.status');
        Route::get('soa-template-01/add', 'CsvTemplateSoaController@add')->name('csv_management.soa_template_01.add');
        Route::get('soa-template-01/edit/{id?}', 'CsvTemplateSoaController@edit')->name('csv_management.soa_template_01.edit');
        Route::post('soa-template-01/store', 'CsvTemplateSoaController@store')->name('csv_management.soa_template_01.store');
        Route::put('soa-template-01/update/{id}', 'CsvTemplateSoaController@update')->name('csv_management.soa_template_01.update');
        /* End SOA Template 01 Routes */

        /* Gradingsheet Template 01 Routes */
        Route::post('gradingsheet-template-01/import', 'CsvTemplateGradingsheetController@import')->name('csv_management.gradingsheet_template_01.import');
        Route::get('gradingsheet-template-01', 'CsvTemplateGradingsheetController@index')->name('csv_management.gradingsheet_template_01.manage_active');
        Route::get('gradingsheet-template-01/inactive', 'CsvTemplateGradingsheetController@inactive')->name('csv_management.gradingsheet_template_01.manage_inactive');
        Route::get('gradingsheet-template-01/all-active', 'CsvTemplateGradingsheetController@all_active')->name('csv_management.gradingsheet_template_01.all_active');
        Route::get('gradingsheet-template-01/all-inactive', 'CsvTemplateGradingsheetController@all_inactive')->name('csv_management.gradingsheet_template_01.all_inactive');
        Route::put('gradingsheet-template-01/update-status/{id}', 'CsvTemplateGradingsheetController@update_status')->name('csv_management.gradingsheet_template_01.update.status');
        Route::get('gradingsheet-template-01/add', 'CsvTemplateGradingsheetController@add')->name('csv_management.gradingsheet_template_01.add');
        Route::get('gradingsheet-template-01/edit/{id?}', 'CsvTemplateGradingsheetController@edit')->name('csv_management.gradingsheet_template_01.edit');
        Route::post('gradingsheet-template-01/store', 'CsvTemplateGradingsheetController@store')->name('csv_management.gradingsheet_template_01.store');
        Route::put('gradingsheet-template-01/update/{id}', 'CsvTemplateGradingsheetController@update')->name('csv_management.gradingsheet_template_01.update');
        /* End Gradingsheet Template 01 Routes */
    });
    /* End CSV Management Routes */

    /* CSV Management Routes */
    Route::prefix('file-management')->group(function () {
        /* SOA Routes */
        Route::post('soa/import', 'FileUploadController@import')->name('file_management.soa.import');
        Route::get('soa', 'FileUploadController@index')->name('file_management.soa.manage_active');
        Route::get('soa/all-active', 'FileUploadController@all_active')->name('file_management.soa.all_active');
        /* End SOA Routes */

        /* Gradingsheet Routes */
        Route::post('gradingsheet/import', 'FileUploadController@import')->name('file_management.gradingsheet.import');
        Route::get('gradingsheet', 'FileUploadController@index')->name('file_management.gradingsheet.manage_active');
        Route::get('gradingsheet/all-active', 'FileUploadController@all_active')->name('file_management.gradingsheet.all_active');
        /* End Gradingsheet Routes */

        /* Payslip Routes */
        Route::post('payslip/import', 'FileUploadController@import')->name('file_management.payslip.import');
        Route::get('payslip', 'FileUploadController@index')->name('file_management.payslip.manage_active');
        Route::get('payslip/all-active', 'FileUploadController@all_active')->name('file_management.payslip.all_active');
        /* End Payslip Routes */
    });
    /* End CSV Management Routes */
    
    /* ID Print Routes */
    Route::prefix('id-management')->group(function () {
        Route::get('print-id', 'PrintIDController@view')->name('print.id.view');
        Route::get('print-id/search/{id?}', 'PrintIDController@search')->name('print.id.view');
    });
    /* End ID Print Routes */
});

Route::prefix('memberships')->group(function () {
    Route::post('students/import', 'StudentsController@import')->name('students.import');
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
    Route::post('staffs/import', 'StaffsController@import')->name('staffs.import');
    Route::post('staffs/uploads', 'StaffsController@uploads')->name('staffs.uploads');
    Route::get('staffs/downloads', 'StaffsController@downloads')->name('staffs.downloads');
    Route::get('staffs/get-all-staffs', 'StaffsController@get_all_staffs')->name('staffs.get_all');
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
    
    Route::get('staffs/get-all-teachers-bytype', 'StaffsController@get_all_teachers_bytype');
    Route::get('staffs/get-all-advisers-bytype', 'StaffsController@get_all_advisers_bytype');
    Route::get('staffs/get-all-teachers', 'StaffsController@get_all_teachers'); 
    /* End Staff Routes */ 
    
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
        Route::get('sections/get-all-sections-bytype/{type}', 'SectionsController@get_all_sections_bytype');
        Route::get('sections/get-all-section-bylevel/{level}/{type}', 'SectionsController@get_all_sections_bylevel');
        Route::post('sections/import', 'SectionsController@import')->name('sections.import');
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
        Route::get('levels/get-all-levels-bytype/{type}', 'LevelsController@get_all_levels_bytype');
        Route::post('levels/import', 'LevelsController@import')->name('levels.import');
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
        Route::get('subjects/get-all-subjects-bytype/{type}', 'SubjectsController@get_all_subjects_bytype');
        Route::post('subjects/import', 'SubjectsController@import')->name('subjects.import');
        /* End Subjects Routes */
    });

    /* Admission Sheets Routes */
    Route::prefix('admissions')->group(function () {  
        /* Admissions */
        Route::get('classes/add', 'AdmissionController@add')->name('sectionstudent.add');
        Route::get('classes/edit/{id?}', 'AdmissionController@edit')->name('sectionstudent.edit');
        Route::post('classes/store', 'AdmissionController@store')->name('sectionstudent.store');
        Route::put('classes/update/{id}', 'AdmissionController@update')->name('sectionstudent.update');
        Route::get('classes', 'AdmissionController@manage')->name('sectionstudent.manage.active');
        Route::get('classes/inactive', 'AdmissionController@inactive')->name('sectionstudent.manage.inactive');
        Route::post('classes/remove', 'AdmissionController@remove')->name('sectionstudent.remove');
        Route::post('classes/restore', 'AdmissionController@restore')->name('sectionstudent.restore');
        Route::get('classes/all-active', 'AdmissionController@all_active')->name('sectionstudent.all.active');
        Route::get('classes/all-inactive', 'AdmissionController@all_inactive')->name('sectionstudent.all.inactive');
        Route::put('classes/update-status/{id}', 'AdmissionController@update_status')->name('sectionstudent.update.status');        
        Route::get('classes/all-admitted', 'AdmissionController@all_admitted')->name('admission.all.admitted');
        Route::get('classes/get-this-admitted/{id?}', 'AdmissionController@get_this_admitted');
        Route::get('classes/get-student-admitted-section/{secid?}', 'AdmissionController@get_this_admitted_section');
        Route::get('classes/save-this-admitted/{id?}/{secid?}', 'AdmissionController@save_this_admitted');
        Route::get('classes/delete-this-admitted/{id?}/{secid?}', 'AdmissionController@delete_this_admitted');
        //Route::post('classes/import-classes', 'AdmissionController@import_class')->name('sectionstudent.fetch.import.class');
        Route::post('classes/import', 'AdmissionController@import')->name('sectionstudent.import');
        Route::post('classes/import-student', 'AdmissionController@import_student')->name('sectionstudent.import.student');
        Route::post('classes/import-subject', 'AdmissionController@import_subject')->name('sectionstudent.import.subject');
        Route::get('classes/remove-admitted-student/{id?}', 'AdmissionController@remove_admitted_student')->name('sectionstudent.remove.admitted');
        Route::get('classes/remove-admitted-student-admission-id/{id?}', 'AdmissionController@remove_admitted_student_admission_id')->name('sectionstudent.remove.admitted.admission.id');
        /* End Admissions Routes */

        /* Enrollment */
        Route::get('enrollments', 'EnrollmentController@manage')->name('enrollments.manage');
        Route::get('enrollments/all-active', 'EnrollmentController@all_active')->name('enrollments.all.active');
        Route::get('enrollments/all-inactive', 'EnrollmentController@all_inactive')->name('enrollments.all.inactive');
        Route::get('enrollments/edit/{id}', 'EnrollmentController@edit')->name('enrollments.edit');
        Route::put('enrollments/update/{id}', 'EnrollmentController@update')->name('enrollments.update');
        /* End Enrollment Routes */
    });

    /* Grading Sheets Routes */
    Route::prefix('grading-sheets')->group(function () {
        /* Start Grading Sheets Routes */
        Route::get('all-gradingsheets/add', 'GradingSheetsController@add')->name('gradingsheets.add');
        Route::get('all-gradingsheets/edit/{id?}', 'GradingSheetsController@edit')->name('gradingsheets.edit');
        Route::get('all-gradingsheets/view/{id?}', 'GradingSheetsController@view')->name('gradingsheets.view');
        Route::post('all-gradingsheets/store', 'GradingSheetsController@store')->name('gradingsheets.store');
        Route::put('all-gradingsheets/update/{id}', 'GradingSheetsController@update')->name('gradingsheets.update');
        Route::put('all-gradingsheets/update-status/{id}', 'GradingSheetsController@update_status')->name('gradingsheets.update.status');
        Route::get('all-gradingsheets/update-rows/{id}', 'GradingSheetsController@update_rows')->name('gradingsheets.update_rows');
        Route::get('all-gradingsheets', 'GradingSheetsController@manage')->name('gradingsheets.manage.active');
        Route::get('all-gradingsheets/inactive', 'GradingSheetsController@inactive')->name('gradingsheets.manage.inactive');
        Route::post('all-gradingsheets/remove', 'GradingSheetsController@remove')->name('gradingsheets.remove');
        Route::post('all-gradingsheets/restore', 'GradingSheetsController@restore')->name('gradingsheets.restore');
        Route::get('all-gradingsheets/all-active', 'GradingSheetsController@all_active')->name('gradingsheets.all.active');
        Route::get('all-gradingsheets/all-inactive', 'GradingSheetsController@all_inactive')->name('gradingsheets.all.inactive');
        Route::get('all-gradingsheets/reload/{id}', 'GradingSheetsController@reload')->name('gradingsheets.reload.all');
        Route::get('all-gradingsheets/reload-subject/{id}', 'GradingSheetsController@reload_subject')->name('gradingsheets.reload.subject');
        Route::get('all-gradingsheets/fetch-transmutations/{id}', 'GradingSheetsController@fetch_transmutations')->name('gradingsheets.fetch.transmutation');
        Route::get('all-gradingsheets/export-gradingsheet/{id}', 'GradingSheetsController@export_gradingsheet')->name('gradingsheets.fetch.export.gradingsheet');
        Route::post('all-gradingsheets/import-gradingsheet/{id}', 'GradingSheetsController@import_gradingsheet')->name('gradingsheets.fetch.import.gradingsheet');
        Route::get('all-gradingsheets/update-activity-header', 'GradingSheetsController@update_activity_header')->name('gradingsheets.update.activity.header');
        Route::get('all-gradingsheets/update-activity-value', 'GradingSheetsController@update_activity_value')->name('gradingsheets.update.activity.value');
        Route::get('all-gradingsheets/get-activity-components', 'GradingSheetsController@get_activity_components')->name('gradingsheets.get.activity.components');
        Route::post('all-gradingsheets/update-components', 'GradingSheetsController@update_components')->name('gradingsheets.update.gradingsheet.components');
        /* End Grading Sheets Routes */

        /* Start Class Record Routes */
        Route::get('class-record', 'ClassRecordController@manage')->name('classrecord.manage');
        Route::get('class-record/all-active', 'ClassRecordController@all_active')->name('classrecord.active');
        Route::get('class-record/view/{id}', 'ClassRecordController@view')->name('classrecord.view');
        Route::get('class-record/export-record/{id}', 'ClassRecordController@export_record')->name('classrecord.fetch.export.record');
        /* End Class Record Routes */

        /* Start Components Routes */
        Route::get('components/reload-quarter-via-type/{id}', 'ComponentsController@reload_quarter')->name('components.reload.quarter');
        Route::get('components/reload-subject-via-section/{id}', 'ComponentsController@reload_subject')->name('components.reload.subject');
        Route::get('components/add', 'ComponentsController@add')->name('components.add');
        Route::get('components/edit/{id}', 'ComponentsController@edit')->name('components.edit');
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

        /* Start Transmutation Routes */
        Route::get('transmutations/add', 'TransmutationsController@add')->name('menus.transmutations.add');
        Route::get('transmutations/edit/{id?}', 'TransmutationsController@edit')->name('menus.transmutations.edit');
        Route::post('transmutations/store', 'TransmutationsController@store')->name('menus.transmutations.store');
        Route::put('transmutations/update/{id}', 'TransmutationsController@update')->name('menus.transmutations.update');
        Route::get('transmutations', 'TransmutationsController@manage')->name('menus.transmutations.manage.active');
        Route::get('transmutations/inactive', 'TransmutationsController@inactive')->name('menus.transmutations.manage.inactive');
        Route::post('transmutations/remove', 'TransmutationsController@remove')->name('menus.transmutations.remove');
        Route::post('transmutations/restore', 'TransmutationsController@restore')->name('menus.transmutations.restore');
        Route::get('transmutations/all-active', 'TransmutationsController@all_active')->name('menus.transmutations.all.active');
        Route::get('transmutations/all-inactive', 'TransmutationsController@all_inactive')->name('menus.transmutations.all.inactive');
        Route::put('transmutations/update-status/{id}', 'TransmutationsController@update_status')->name('menus.transmutations.update.status');
        /* End Transmutation Routes */

        /* Start Report Card Routes */
        Route::get('report-card/export', 'ReportCardController@export')->name('report.card.export');
        Route::get('report-card/export-view', 'ReportCardController@export_view')->name('report.card.export_view');
        Route::get('report-card/reload-classes', 'ReportCardController@reload_classes')->name('report.card.reload_classes');
        Route::get('report-card/reload-students', 'ReportCardController@reload_students')->name('report.card.reload_students');
        /* End Report Card Routes */

        /* Start Report Card Routes */
        Route::get('transcript-of-record/export', 'TranscriptRecordController@export')->name('transcript.record.export');
        Route::get('transcript-of-record/export-view', 'TranscriptRecordController@export_view')->name('transcript.record.export_view');
        Route::get('transcript-of-record/reload-classes', 'TranscriptRecordController@reload_classes')->name('transcript.record.reload_classes');
        Route::get('transcript-of-record/reload-students', 'TranscriptRecordController@reload_students')->name('transcript.record.reload_students');
        Route::get('transcript-of-record/fetch-students', 'TranscriptRecordController@fetch_students')->name('transcript.record.students');
        /* End Report Card Routes */
        
    });
    /* End Grading Sheets Routes */

    /* Start Attendance Sheets */
    Route::prefix('attendance-sheets')->group(function () {
        
        /* Start Staff Attendance */
        Route::prefix('staff-attendance')->group(function () {
            Route::get('file-attendance', 'StaffFileAttendanceController@manage')->name('file.staff.attendance.manage.active');
            Route::get('file-attendance/all-active', 'StaffFileAttendanceController@all_active')->name('file.staff.attendance.all.active');
            Route::get('file-attendance/inactive', 'StaffFileAttendanceController@inactive')->name('file.staff.attendance.all.inactive');
            Route::get('file-attendance/add', 'StaffFileAttendanceController@add')->name('file.staff.attendance.all.add');
            Route::get('file-attendance/edit/{id?}', 'StaffFileAttendanceController@edit')->name('file.staff.attendance.edit');
            Route::post('file-attendance/store', 'StaffFileAttendanceController@store')->name('file.staff.attendance.store');
            Route::put('file-attendance/update/{id}', 'StaffFileAttendanceController@update')->name('file.staff.attendance.update');
            Route::get('file-attendance/all-inactive', 'StaffFileAttendanceController@all_inactive')->name('menus.transmutations.all.inactive');
        });
        /* End Staff Attendance */

        /* Start Staff Attendance Settings */
        Route::prefix('staff-attendance')->group(function () {
            Route::get('settings', 'StaffSettingsController@manage')->name('staff.settings.manage.active');
            Route::get('settings/add', 'StaffSettingsController@add')->name('staff.settings.add');
            Route::get('settings/edit/{id?}', 'StaffSettingsController@edit')->name('staff.settings.edit');
            Route::post('settings/store', 'StaffSettingsController@store')->name('staff.settings.store');
            Route::put('settings/update/{id}', 'StaffSettingsController@update')->name('staff.settings.update');
            Route::get('settings/all-active', 'StaffSettingsController@all_active')->name('staff.settings.all.active');
            
        });
        /* End Staff Attendance Settings */

        /* Start Student Attendance */
        Route::prefix('student-attendance')->group(function () {
            Route::get('file-attendance', 'StudentFileAttendanceController@manage')->name('file.student.attendance.manage.active');
            Route::get('file-attendance/all-active', 'StudentFileAttendanceController@all_active')->name('file.student.attendance.all.active');
            Route::get('file-attendance/inactive', 'StudentFileAttendanceController@inactive')->name('file.student.attendance.all.inactive');
            Route::get('file-attendance/add', 'StudentFileAttendanceController@add')->name('file.student.attendance.all.add');
            Route::get('file-attendance/edit/{id?}', 'StudentFileAttendanceController@edit')->name('file.student.attendance.edit');
            Route::post('file-attendance/store', 'StudentFileAttendanceController@store')->name('file.student.attendance.store');
            Route::put('file-attendance/update/{id}', 'StudentFileAttendanceController@update')->name('file.student.attendance.update');
            Route::get('file-attendance/all-inactive', 'StudentFileAttendanceController@all_inactive')->name('menus.transmutations.all.inactive');
        });
        /* End Student Attendance */

        /* Start Student Attendance Settings */
        Route::prefix('student-attendance')->group(function () {
            Route::get('settings', 'StudentSettingsController@manage')->name('student.settings.manage.active');
            Route::get('settings/add', 'StudentSettingsController@add')->name('student.settings.add');
            Route::get('settings/edit/{id?}', 'StudentSettingsController@edit')->name('student.settings.edit');
            Route::post('settings/store', 'StudentSettingsController@store')->name('student.settings.store');
            Route::put('settings/update/{id}', 'StudentSettingsController@update')->name('student.settings.update');
            Route::get('settings/all-active', 'StudentSettingsController@all_active')->name('student.settings.all.active');
            
        });
        /* End Student Attendance Settings */        

        /* Start For Approval */
        Route::get('attendance-report', 'AttendanceReportController@manage')->name('attendancereport.manage.active');
        Route::get('attendance-report/export-view', 'AttendanceReportController@export_view')->name('attendancereport.export_view');

        Route::get('attendance-report/add', 'AttendanceReportController@add')->name('attendancereport.add');
        Route::get('attendance-report/edit/{id?}', 'AttendanceReportController@edit')->name('attendancereport.edit');
        Route::post('attendance-report/store', 'AttendanceReportController@store')->name('attendancereport.store');
        Route::put('attendance-report/update/{id}', 'AttendanceReportController@update')->name('attendancereport.update');
        Route::get('attendance-report/all-active', 'AttendanceReportController@all_active')->name('attendancereport.all.active');
        Route::put('attendance-report/update-status/{id}', 'AttendanceReportController@update_status')->name('attendancereport.update.status');
        /* End For Approval */    

        /* Start For Approval */
        Route::get('for-approval', 'AttendanceSheetController@manage')->name('attendancesheet.manage.active');
        Route::get('for-approval/add', 'AttendanceSheetController@add')->name('attendancesheet.add');
        Route::get('for-approval/edit/{id?}', 'AttendanceSheetController@edit')->name('attendancesheet.edit');
        Route::post('for-approval/store', 'AttendanceSheetController@store')->name('attendancesheet.store');
        Route::put('for-approval/update/{id}', 'AttendanceSheetController@update')->name('attendancesheet.update');
        Route::get('for-approval/all-active', 'AttendanceSheetController@all_active')->name('attendancesheet.all.active');
        Route::put('for-approval/update-status/{id}', 'AttendanceSheetController@update_status')->name('attendancesheet.update.status');
        /* End For Approval */   
    });
    /* End Attendance Sheets */
});

/* Notifications Routes */
Route::prefix('notifications')->group(function () {
    /* Messaging Routes */
    Route::prefix('messaging')->group(function () {
        /* Infoblast Routes */
        Route::prefix('infoblast')->group(function () {
            Route::get('new', 'InfoblastController@new')->name('messaging.infoblast.new');
            Route::get('inbox', 'InfoblastController@inbox')->name('messaging.infoblast.inbox');
            Route::get('get-inboxes-via-msisdn', 'InfoblastController@get_inboxes_via_msisdn')->name('messaging.infoblast.get_inboxes');
            Route::get('outbox', 'InfoblastController@outbox')->name('messaging.infoblast.outbox');
            Route::get('active-outbox', 'InfoblastController@active_outbox')->name('messaging.infoblast.active_outbox');
            Route::get('tracking', 'InfoblastController@tracking')->name('messaging.infoblast.tracking');
            Route::get('active-tracking', 'InfoblastController@active_tracking')->name('messaging.infoblast.active_tracking');
            Route::post('resend-item/{id}', 'InfoblastController@resend_item')->name('messaging.infoblast.resend');
            Route::post('send', 'InfoblastController@send')->name('messaging.infoblast.send');

            Route::get('search-group', 'InfoblastController@search_group')->name('messaging.infoblast.search_group');
            Route::get('search-section', 'InfoblastController@search_section')->name('messaging.infoblast.search_section');
            Route::get('search-user', 'InfoblastController@search_user')->name('messaging.infoblast.search_user');

            Route::get('templates', 'InfoblastController@templates')->name('messaging.infoblast.templates');
            Route::get('templates/inactive', 'InfoblastController@inactive_templates')->name('messaging.infoblast.inactive_templates');
            Route::get('templates/all-active', 'InfoblastController@all_active_templates')->name('messaging.infoblast.all_active_templates');
            Route::get('templates/all-inactive', 'InfoblastController@all_inactive_templates')->name('messaging.infoblast.all_inactive_templates');
            Route::get('templates/add', 'InfoblastController@messaging_template')->name('messaging.infoblast.add_template');
            Route::get('templates/edit/{id?}', 'InfoblastController@messaging_template')->name('student.settings.edit_template');
            Route::post('templates/store', 'InfoblastController@store_template')->name('messaging.infoblast.store_template');
            Route::put('templates/update/{id}', 'InfoblastController@update_template')->name('messaging.infoblast.update_template');
            Route::put('templates/update-status/{id}', 'InfoblastController@update_template_status')->name('messaging.infoblast.update_template_status');
            Route::get('templates/fetch', 'InfoblastController@fetch_all_template')->name('messaging.infoblast.fetch_all_template');
        });
        /* End Infoblast Routes */

        /* Emailblast Routes */
        Route::prefix('emailblast')->group(function () {
            Route::get('new', 'EmailblastController@new')->name('messaging.emailblast.new');
            Route::post('store', 'EmailblastController@store')->name('messaging.emailblast.store');
            Route::get('send', 'EmailblastController@send')->name('messaging.emailblast.send');
            //Route::post('uploads', 'EmailblastController@uploads')->name('messaging.emailblast.uploads');
            Route::get('inbox', 'EmailblastController@inbox')->name('messaging.emailblast.inbox');
            Route::get('outbox', 'EmailblastController@manage_outbox')->name('messaging.emailblast.manage.outbox');
            Route::get('outbox/all-active', 'EmailblastController@all_active_outbox')->name('messaging.emailblast.all.active.outbox');
            Route::post('uploads', 'EmailblastController@uploads')->name('messaging.emailblast.uploads');
            
            //Settings
            Route::get('settings', 'EmailblastController@settings')->name('messaging.emailblast.settings');
            Route::get('settings/all-active', 'EmailblastController@all_active_settings')->name('messaging.emailblast.all.active.settings');
            Route::get('settings/add', 'EmailblastController@add_settings')->name('messaging.emailblast.add.settings');
            Route::post('settings/store', 'EmailblastController@store_settings')->name('messaging.emailblast.settings.store');
            Route::get('settings/edit/{id?}', 'EmailblastController@edit_settings')->name('messaging.emailblast.edit.settings');
            Route::put('settings/update/{id}', 'EmailblastController@update_settings')->name('messaging.emailblast.settings.update');
            Route::put('settings/update-status/{id}', 'EmailblastController@update_status')->name('messaging.emailblast.settings.update.status');
        });
        /* End Emailblast Routes */

    });
    /* End Messaging Routes */
});
/* End Notifcations Routes */

Route::prefix('dashboard')->group(function () {
    Route::get('', 'DashboardController@index')->name('dashboard');
    Route::get('get-all-open-batches', 'DashboardController@open_batches')->name('dashboard.open');
    Route::get('update-current/{id}', 'DashboardController@update_current')->name('dashboard.update');
    Route::get('get-returned-students', 'DashboardController@get_returned_students')->name('dashboard.return.students');
    Route::get('get-new-students', 'DashboardController@get_new_students')->name('dashboard.new.students');
    Route::get('get-active-users', 'DashboardController@get_active_users')->name('dashboard.active.users');
    Route::get('get-active-students-per-malefemale', 'DashboardController@get_active_students_per_malefemale')->name('dashboard.active.students.male_female');
    Route::get('get-calendar', 'DashboardController@get_calendar')->name('dashboard.calendar');
    Route::get('get-active-students-per-level', 'DashboardController@get_active_students_per_level')->name('dashboard.active.students.level');
});

Route::prefix('settings')->group(function () {
    Route::get('', 'SettingsController@index')->name('settings');
    Route::post('update', 'SettingsController@update')->name('settings.update');
    Route::post('uploads', 'SettingsController@uploads')->name('settings.uploads');
});


/* Guest Routes */
Route::get('upload-id', 'GuestController@index')->name('guest.upload');
Route::post('upload-data', 'GuestController@upload_data')->name('guest.uploads');
Route::post('upload-photo', 'GuestController@upload_photo')->name('guest.uploads');
Route::get('enrollment', 'EnrollmentController@index')->name('enrollment.new');
Route::post('enrollment/store', 'EnrollmentController@store')->name('enrollment.save');
Route::post('enrollment/uploads', 'EnrollmentController@uploads')->name('enrollment.uploads');
Route::get('enrollment/search', 'EnrollmentController@search')->name('enrollment.search');
/* End Guest Routes */

Route::get('/send-mail', function () {
    Mail::to('aranfure@gmail.com')->send(new UserNotification()); 
    return 'A message has been sent to Mailtrap!';
});