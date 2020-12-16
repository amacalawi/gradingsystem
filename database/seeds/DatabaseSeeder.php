<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $secrets = [
            [
                'code' => "What is your mother's maiden name?",
                'name' => "What is your mother's maiden name?",
                'description' => "What is your mother's maiden name?",
                'created_by' => 1
            ], 
            [
                'code' => "What is your first pet's name?",
                'name' => "What is your first pet's name?",
                'description' => "What is your first pet's name?",
                'created_by' => 1
            ], 
            [
                'code' => "What was the model of your first car?",
                'name' => "What was the model of your first car?",
                'description' => "What was the model of your first car?",
                'created_by' => 1
            ],
            [
                'code' => "In what city were you born?",
                'name' => "In what city were you born?",
                'description' => "In what city were you born?",
                'created_by' => 1
            ],
            [
                'code' => "What was your father's middle name?",
                'name' => "What was your father's middle name?",
                'description' => "What was your father's middle name?",
                'created_by' => 1
            ],
            [
                'code' => "What was your childhood nickname?",
                'name' => "What was your childhood nickname?",
                'description' => "What was your childhood nickname?",
                'created_by' => 1
            ]
        ];
        foreach ($secrets as $secret) {
            DB::table('secret_questions')->insert($secret);
        }

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin',
            'username' => 'superadmin',
            'password' => '$2y$10$mEzN8zr327/0Qp/GebqspOik64vXbnfiuala5n6bnUxpAvvS9Ndni',
            'secret_question_id' => 1,
            'secret_password' => '$2y$10$mEzN8zr327/0Qp/GebqspOik64vXbnfiuala5n6bnUxpAvvS9Ndni',
            'type' => 'administrator'
        ]);

        $roles = [
            [
                'code' => 'superadmin',
                'name' => 'Super Admin',
                'description' => 'Super Admin Role',
                'created_by' => 1
            ], 
            [
                'code' => 'admin',
                'name' => 'Admin',
                'description' => 'Admin Role',
                'created_by' => 1
            ],
            [
                'code' => 'staff',
                'name' => 'Staff',
                'description' => 'Staff Role',
                'created_by' => 1
            ],
            [
                'code' => 'student',
                'name' => 'Student',
                'description' => 'Student Role',
                'created_by' => 1
            ],
            [
                'code' => 'parent',
                'name' => 'Parent',
                'description' => 'Parent Role',
                'created_by' => 1
            ],
            [
                'code' => 'registrar',
                'name' => 'Registrar',
                'description' => 'Registrar Role',
                'created_by' => 1
            ],
            [
                'code' => 'accounting',
                'name' => 'Accounting',
                'description' => 'Accounting Role',
                'created_by' => 1
            ]
        ];
        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

        DB::table('users_roles')->insert([
            'user_id' => 1,
            'role_id' => 1,
            'created_by' => 1
        ]);

        $headers = [
            [
                'code' => 'academics',
                'name' => 'Academics',
                'description' => 'Academics Description',
                'slug' => 'academics',
                'order' => '1',
                'created_by' => 1
            ], 
            [
                'code' => 'components',
                'name' => 'Components',
                'description' => 'Components Description',
                'slug' => 'components',
                'order' => '2',
                'created_by' => 1
            ], 
            [
                'code' => 'memberships',
                'name' => 'Memberships',
                'description' => 'Memberships Description',
                'slug' => 'memberships',
                'order' => '3',
                'created_by' => 1
            ],
            [
                'code' => 'notifications',
                'name' => 'Notifications',
                'description' => 'Notifications Description',
                'slug' => 'notifications',
                'order' => '4',
                'created_by' => 1
            ]
        ];
        foreach ($headers as $header) {
            DB::table('headers')->insert($header);
        }

        $modules = [
            [   
                'header_id' => '1',
                'code' => 'academics',
                'name' => 'Academics',
                'description' => 'Academics Description',
                'slug' => 'academics',
                'icon' => 'fa fa-mortar-board',
                'order' => '1',
                'created_by' => 1
            ],
            [   
                'header_id' => '1',
                'code' => 'admissions',
                'name' => 'Admissions',
                'description' => 'Admissions Description',
                'slug' => 'admissions',
                'icon' => 'fa fa-university',
                'order' => '2',
                'created_by' => 1
            ], 
            [   
                'header_id' => '1',
                'code' => 'grading-sheets',
                'name' => 'Grading Sheets',
                'description' => 'Grading Sheets Description',
                'slug' => 'grading-sheets',
                'icon' => 'fa fa-file-text-o',
                'order' => '3',
                'created_by' => 1
            ], 
            [   
                'header_id' => '1',
                'code' => 'attendance-sheets',
                'name' => 'Attendance Sheets',
                'description' => 'Attendance Sheets Description',
                'slug' => 'attendance-sheets',
                'icon' => 'fa fa-calendar-check-o',
                'order' => '4',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'schools',
                'name' => 'Schools',
                'description' => 'Schools Description',
                'slug' => 'schools',
                'icon' => 'fa fa-university',
                'order' => '5',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'groups',
                'name' => 'Groups',
                'description' => 'Groups Description',
                'slug' => 'groups',
                'icon' => 'fa fa-group',
                'order' => '6',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'schedules',
                'name' => 'Schedules',
                'description' => 'Schedules Description',
                'slug' => 'schedules',
                'icon' => 'fa fa-calendar-o',
                'order' => '7',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'calendars',
                'name' => 'Calendars',
                'description' => 'Calendars Description',
                'slug' => 'calendars',
                'icon' => 'fa fa-calendar',
                'order' => '8',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'menus',
                'name' => 'Menus',
                'description' => 'Menus Description',
                'slug' => 'menus',
                'icon' => 'fa fa-list',
                'order' => '9',
                'created_by' => 1
            ],
            [   
                'header_id' => '3',
                'code' => 'students',
                'name' => 'Students',
                'description' => 'Students Description',
                'slug' => 'students',
                'icon' => 'la la-user',
                'order' => '10',
                'created_by' => 1
            ],
            [   
                'header_id' => '3',
                'code' => 'staffs',
                'name' => 'Staffs',
                'description' => 'Staffs Description',
                'slug' => 'staffs',
                'icon' => 'fa fa-user-secret',
                'order' => '11',
                'created_by' => 1
            ],
            [   
                'header_id' => '3',
                'code' => 'users',
                'name' => 'Users',
                'description' => 'Users Description',
                'slug' => 'users',
                'icon' => 'la la-users',
                'order' => '12',
                'created_by' => 1
            ],
            [   
                'header_id' => '4',
                'code' => 'messaging',
                'name' => 'Messaging',
                'description' => 'Messaging Description',
                'slug' => 'messaging',
                'icon' => 'la la-comments',
                'order' => '13',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'csv-management',
                'name' => 'CSV Management',
                'description' => 'CSV Management Description',
                'slug' => 'csv-management',
                'icon' => 'la la-file-excel-o',
                'order' => '14',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'file-management',
                'name' => 'File Management',
                'description' => 'File Management Description',
                'slug' => 'file-management',
                'icon' => 'la la-file-pdf-o',
                'order' => '15',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'id-management',
                'name' => 'ID Management',
                'description' => 'ID Management Description',
                'slug' => 'id-management',
                'icon' => 'la la-file-photo-o',
                'order' => '16',
                'created_by' => 1
            ]
        ];
        foreach ($modules as $module) {
            DB::table('modules')->insert($module);
        }

        $sub_modules = [
            [   
                'module_id' => '1',
                'code' => 'sections',
                'name' => 'Sections',
                'description' => 'Sections Description',
                'slug' => 'sections',
                'icon' => '',
                'order' => '1',
                'created_by' => 1
            ], 
            [   
                'module_id' => '1',
                'code' => 'levels',
                'name' => 'Levels',
                'description' => 'Levels Description',
                'slug' => 'levels',
                'icon' => '',
                'order' => '2',
                'created_by' => 1
            ], 
            [   
                'module_id' => '1',
                'code' => 'subjects',
                'name' => 'Subjects',
                'description' => 'Subjects Description',
                'slug' => 'subjects',
                'icon' => '',
                'order' => '3',
                'created_by' => 1
            ],
            [   
                'module_id' => '2',
                'code' => 'classes',
                'name' => 'Classes',
                'description' => 'Classes Description',
                'slug' => 'classes',
                'icon' => '',
                'order' => '43',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'all-gradingsheets',
                'name' => 'All Grading Sheets',
                'description' => 'All Grading Sheets Description',
                'slug' => 'all-gradingsheets',
                'icon' => '',
                'order' => '5',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'class-record',
                'name' => 'Class Record',
                'description' => 'Class Record Description',
                'slug' => 'class-record',
                'icon' => '',
                'order' => '6',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'components',
                'name' => 'Components',
                'description' => 'Components Description',
                'slug' => 'components',
                'icon' => '',
                'order' => '7',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'transmutations',
                'name' => 'Transmutations',
                'description' => 'Transmutations Description',
                'slug' => 'transmutations',
                'icon' => '',
                'order' => '8',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'student-attendance',
                'name' => 'Student Attendance',
                'description' => 'Student Attendance Description',
                'slug' => 'student-attendance',
                'icon' => '',
                'order' => '9',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'staff-attendance',
                'name' => 'Staff Attendance',
                'description' => 'Staff Attendance Description',
                'slug' => 'staff-attendance',
                'icon' => '',
                'order' => '10',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'attendance-report',
                'name' => 'Attendance Report',
                'description' => 'Attendance Report Description',
                'slug' => 'attendance-report',
                'icon' => '',
                'order' => '11',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'for-approval',
                'name' => 'For Approval',
                'description' => 'For Approval Description',
                'slug' => 'for-approval',
                'icon' => '',
                'order' => '12',
                'created_by' => 1
            ],            
            [   
                'module_id' => '5',
                'code' => 'schoolyears',
                'name' => 'Schoolyears',
                'description' => 'Schoolyear Description',
                'slug' => 'schoolyears',
                'icon' => '',
                'order' => '13',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'quarters',
                'name' => 'Quarters',
                'description' => 'Quarters Description',
                'slug' => 'quarters',
                'icon' => '',
                'order' => '14',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'departments',
                'name' => 'Departments',
                'description' => 'Departments Description',
                'slug' => 'departments',
                'icon' => '',
                'order' => '15',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'designations',
                'name' => 'Designations',
                'description' => 'Designations Description',
                'slug' => 'designations',
                'icon' => '',
                'order' => '16',
                'created_by' => 1
            ],
            [   
                'module_id' => '6',
                'code' => 'manage-all-groups',
                'name' => 'All Active Groups',
                'description' => 'All Active Groups Description',
                'slug' => '',
                'icon' => '',
                'order' => '17',
                'created_by' => 1
            ],
            [   
                'module_id' => '6',
                'code' => 'manage-all-inactive-groups',
                'name' => 'All Inactive Groups',
                'description' => 'All Inactive Groups Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '18',
                'created_by' => 1
            ],
            [   
                'module_id' => '7',
                'code' => 'all-active-schedules',
                'name' => 'All Active Schedules',
                'description' => 'All Active Schedules Description',
                'slug' => '',
                'icon' => '',
                'order' => '19',
                'created_by' => 1
            ],
            [   
                'module_id' => '7',
                'code' => 'all-inactive-schedules',
                'name' => 'All Inactive Schedules',
                'description' => 'All Inactive Schedules Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '20',
                'created_by' => 1
            ],
            [   
                'module_id' => '7',
                'code' => 'all-preset-messages',
                'name' => 'All Preset Messages',
                'description' => 'All Preset Messages Description',
                'slug' => 'preset-message',
                'icon' => '',
                'order' => '21',
                'created_by' => 1
            ],
            [   
                'module_id' => '8',
                'code' => 'all-active-calendars',
                'name' => 'All Active Calendars',
                'description' => 'All Active Calendars Description',
                'slug' => '',
                'icon' => '',
                'order' => '22',
                'created_by' => 1
            ],

            [   
                'module_id' => '9',
                'code' => 'headers',
                'name' => 'Headers',
                'description' => 'Headers Description',
                'slug' => 'headers',
                'icon' => '',
                'order' => '23',
                'created_by' => 1
            ],
            [   
                'module_id' => '9',
                'code' => 'modules',
                'name' => 'Modules',
                'description' => 'Modules Description',
                'slug' => 'modules',
                'icon' => '',
                'order' => '24',
                'created_by' => 1
            ],
            [   
                'module_id' => '9',
                'code' => 'sub-modules',
                'name' => 'Sub Modules',
                'description' => 'Sub Modules Description',
                'slug' => 'sub-modules',
                'icon' => '',
                'order' => '25',
                'created_by' => 1
            ],
            [   
                'module_id' => '10',
                'code' => 'all-active-students',
                'name' => 'All Active Students',
                'description' => 'All Active Students Description',
                'slug' => '',
                'icon' => '',
                'order' => '26',
                'created_by' => 1
            ],
            [   
                'module_id' => '10',
                'code' => 'all-inactive-students',
                'name' => 'All Inactive Students',
                'description' => 'All Inactive Students Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '27',
                'created_by' => 1
            ],
            [   
                'module_id' => '11',
                'code' => 'all-active-staffs',
                'name' => 'All Active Staffs',
                'description' => 'All Active Staffs Description',
                'slug' => '',
                'icon' => '',
                'order' => '28',
                'created_by' => 1
            ],
            [   
                'module_id' => '11',
                'code' => 'all-inactive-staffs',
                'name' => 'All Inactive Staffs',
                'description' => 'All Inactive Staffs Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '29',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'accounts',
                'name' => 'Accounts',
                'description' => 'Accounts Description',
                'slug' => 'accounts',
                'icon' => '',
                'order' => '30',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'roles-and-permissions',
                'name' => 'Roles And Permissions',
                'description' => 'Roles And Permissions Description',
                'slug' => 'roles',
                'icon' => '',
                'order' => '31',
                'created_by' => 1
            ],
            [   
                'module_id' => '13',
                'code' => 'infoblast',
                'name' => 'Infoblast',
                'description' => 'Infoblast Description',
                'slug' => 'infoblast',
                'icon' => '',
                'order' => '32',
                'created_by' => 1
            ],
            [   
                'module_id' => '13',
                'code' => 'emailblast',
                'name' => 'Emailblast',
                'description' => 'Emailblast Description',
                'slug' => 'emailblast',
                'icon' => '',
                'order' => '33',
                'created_by' => 1
            ],
            [   
                'module_id' => '13',
                'code' => 'systemblast',
                'name' => 'Systemblast',
                'description' => 'Systemblast Description',
                'slug' => 'systemblast',
                'icon' => '',
                'order' => '34',
                'created_by' => 1
            ],
            [   
                'module_id' => '13',
                'code' => 'configuration',
                'name' => 'Configuration',
                'description' => 'Configuration Description',
                'slug' => 'configuration',
                'icon' => '',
                'order' => '35',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'education-types',
                'name' => 'Education Types',
                'description' => 'Education Types',
                'slug' => 'education-types',
                'icon' => '',
                'order' => '36',
                'created_by' => 1
            ],
            [   
                'module_id' => '16',
                'code' => 'print-id',
                'name' => 'Print',
                'description' => 'Print',
                'slug' => 'print-id',
                'icon' => '',
                'order' => '37',
                'created_by' => 1
            ],
            [   
                'module_id' => '16',
                'code' => 'settings-id',
                'name' => 'Settings',
                'description' => 'Settings',
                'slug' => 'settings-id',
                'icon' => '',
                'order' => '38',
                'created_by' => 1
            ],
            [   
                'module_id' => '14',
                'code' => 'soa-template-01',
                'name' => 'SOA Template 01',
                'description' => 'SOA Template 01 Description',
                'slug' => 'soa-template-01',
                'icon' => '',
                'order' => '39',
                'created_by' => 1
            ],
            [   
                'module_id' => '14',
                'code' => 'gradingsheet-template-01',
                'name' => 'Gradingsheet Template 01',
                'description' => 'Gradingsheet Template 01 Description',
                'slug' => 'gradingsheet-template-01',
                'icon' => '',
                'order' => '40',
                'created_by' => 1
            ],
            [   
                'module_id' => '15',
                'code' => 'soa',
                'name' => 'SOA',
                'description' => 'SOA Description',
                'slug' => 'soa',
                'icon' => '',
                'order' => '41',
                'created_by' => 1
            ],
            [   
                'module_id' => '15',
                'code' => 'gradingsheet',
                'name' => 'Gradingsheet',
                'description' => 'Gradingsheet Description',
                'slug' => 'gradingsheet',
                'icon' => '',
                'order' => '42',
                'created_by' => 1
            ],
            [   
                'module_id' => '15',
                'code' => 'payslip',
                'name' => 'Payslip',
                'description' => 'Payslip Description',
                'slug' => 'payslip',
                'icon' => '',
                'order' => '43',
                'created_by' => 1
            ],
            [   
                'module_id' => '2',
                'code' => 'enrollments',
                'name' => 'Enrollments',
                'description' => 'Enrollments Description',
                'slug' => 'enrollments',
                'icon' => '',
                'order' => '44',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'report-card',
                'name' => 'Report Card',
                'description' => 'Report Card Description',
                'slug' => 'report-card',
                'icon' => '',
                'order' => '45',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'transcript-of-record',
                'name' => 'Transcript of Record',
                'description' => 'Transcript of Record Description',
                'slug' => 'transcript-of-record',
                'icon' => '',
                'order' => '46',
                'created_by' => 1
            ]
        ];
        foreach ($sub_modules as $sub_module) {
            DB::table('sub_modules')->insert($sub_module);
        }

        $roles_headers = [
            [   
                'role_id' => '1',
                'header_id' => '1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'header_id' => '2',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'header_id' => '3',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'header_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'header_id' => '1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'header_id' => '2',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'header_id' => '3',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'header_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'header_id' => '1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '3',
                'header_id' => '2',
                'created_by' => 1
            ], 
            [   
                'role_id' => '3',
                'header_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '4',
                'header_id' => '1',
                'created_by' => 1
            ],
            [   
                'role_id' => '5',
                'header_id' => '1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'header_id' => '1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'header_id' => '2',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'header_id' => '3',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'header_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'header_id' => '1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'header_id' => '2',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'header_id' => '4',
                'created_by' => 1
            ]
        ];

        foreach ($roles_headers as $roles_header) {
            DB::table('roles_headers')->insert($roles_header);
        }

        $roles_modules = [
            [   
                'role_id' => '1',
                'module_id' => '1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '2',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '3',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '5',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '6',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '7',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '8',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '9',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '10',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'module_id' => '11',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '12',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '13',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '14',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '15',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'module_id' => '16',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '2',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '3',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '5',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '6',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '7',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '8',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '9',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '10',
                'created_by' => 1
            ], 
            [   
                'role_id' => '2',
                'module_id' => '11',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '12',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '13',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '14',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '15',
                'created_by' => 1
            ],
            [   
                'role_id' => '2',
                'module_id' => '16',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'module_id' => '3',
                'created_by' => 1
            ], 
            [   
                'role_id' => '3',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'module_id' => '13',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'module_id' => '14',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'module_id' => '15',
                'created_by' => 1
            ],
            [   
                'role_id' => '4',
                'module_id' => '3',
                'created_by' => 1
            ],
            [   
                'role_id' => '4',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '5',
                'module_id' => '3',
                'created_by' => 1
            ],
            [   
                'role_id' => '5',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '2',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '3',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '5',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '10',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '11',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '13',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '14',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '15',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'module_id' => '16',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '2',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '4',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '10',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '11',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '13',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '14',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'module_id' => '15',
                'created_by' => 1
            ]
        ];

        foreach ($roles_modules as $roles_module) {
            DB::table('roles_modules')->insert($roles_module);
        }
        
        $roles_sub_modules = [
            [   
                'role_id' => '1',
                'sub_module_id' => '1',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '2',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '3',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '4',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '5',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '6',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '7',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '8',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '9',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '10',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '11',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '12',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '13',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '14',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '15',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '16',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '17',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '18',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '19',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '20',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '21',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '22',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '23',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '24',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '25',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '26',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '27',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ], 
            [   
                'role_id' => '1',
                'sub_module_id' => '28',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '29',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '30',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '31',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '32',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '33',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '34',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '35',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '36',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '37',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '38',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '39',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '40',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '41',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '42',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '43',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '44',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '45',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '1',
                'sub_module_id' => '46',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '5',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '6',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '7',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '8',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '10',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '11',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '12',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '32',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '33',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '39',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '40',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '41',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '42',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '3',
                'sub_module_id' => '43',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '4',
                'sub_module_id' => '9',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '4',
                'sub_module_id' => '12',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '4',
                'sub_module_id' => '45',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '5',
                'sub_module_id' => '9',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '5',
                'sub_module_id' => '12',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '5',
                'sub_module_id' => '45',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '1',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '2',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '3',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '4',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '7',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '8',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '10',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '12',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '13',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '14',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '15',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '16',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '26',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '27',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '28',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '29',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '32',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '33',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '36',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '37',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '38',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '39',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '40',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '41',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '42',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '43',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '44',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '45',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '6',
                'sub_module_id' => '46',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '4',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '10',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '12',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '26',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '27',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '28',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '29',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '32',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '33',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '39',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '40',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '41',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '42',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '43',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ],
            [   
                'role_id' => '7',
                'sub_module_id' => '44',
                'permissions' => '1,1,1,1',
                'created_by' => 1
            ]
        ];

        foreach ($roles_sub_modules as $roles_sub_module) {
            DB::table('roles_sub_modules')->insert($roles_sub_module);
        }

        $transmutations = [
            [   
                'code' => 'early-childhood-transmutation',
                'name' => 'Early Childhood Transmutation',
                'description' => 'Early Childhood Description Transmutation',
                'education_type_id' => '1',
                'created_by' => 1
            ], 
            [   
                'code' => 'grade-school-transmutation',
                'name' => 'Grade School Transmutation',
                'description' => 'Grade School Description Transmutation',
                'education_type_id' => '2',
                'created_by' => 1
            ], 
            [   
                'code' => 'junior-highschool-transmutation',
                'name' => 'Junior High School Transmutation',
                'description' => 'Junior High School Description Transmutation',
                'education_type_id' => '3',
                'created_by' => 1
            ], 
            [   
                'code' => 'senior-highschool-transmutation',
                'name' => 'Senior High School Transmutation',
                'description' => 'Senior High School Description Transmutation',
                'education_type_id' => '4',
                'created_by' => 1
            ]
        ];

        foreach ($transmutations as $transmutation) {
            DB::table('transmutations')->insert($transmutation);
        }

        $transmutations_elements = [
            [   
                'transmutation_id' => '1',
                'score' => '0.00',
                'equivalent' => '60',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '4.00',
                'equivalent' => '61',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '8.00',
                'equivalent' => '62',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '12.00',
                'equivalent' => '63',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '16.00',
                'equivalent' => '64',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '20.00',
                'equivalent' => '65',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '24.00',
                'equivalent' => '66',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '28.00',
                'equivalent' => '67',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '32.00',
                'equivalent' => '68',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '36.00',
                'equivalent' => '69',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '40.00',
                'equivalent' => '70',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '44.00',
                'equivalent' => '71',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '48.00',
                'equivalent' => '72',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '52.00',
                'equivalent' => '73',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '56.00',
                'equivalent' => '74',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '60.00',
                'equivalent' => '75',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '61.60',
                'equivalent' => '76',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '63.20',
                'equivalent' => '77',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '64.80',
                'equivalent' => '78',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '66.40',
                'equivalent' => '79',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '68.00',
                'equivalent' => '80',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '69.60',
                'equivalent' => '81',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '71.20',
                'equivalent' => '82',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '72.80',
                'equivalent' => '83',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '74.40',
                'equivalent' => '84',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '76.00',
                'equivalent' => '85',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '77.60',
                'equivalent' => '86',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '79.20',
                'equivalent' => '87',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '80.80',
                'equivalent' => '88',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '82.40',
                'equivalent' => '89',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '84.00',
                'equivalent' => '90',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '85.60',
                'equivalent' => '91',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '87.20',
                'equivalent' => '92',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '88.80',
                'equivalent' => '93',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '90.40',
                'equivalent' => '94',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '92.00',
                'equivalent' => '95',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '93.60',
                'equivalent' => '96',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '95.20',
                'equivalent' => '97',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '96.80',
                'equivalent' => '98',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '1',
                'score' => '98.40',
                'equivalent' => '99',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '1',
                'score' => '100.00',
                'equivalent' => '100',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '0.00',
                'equivalent' => '60',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '4.00',
                'equivalent' => '61',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '8.00',
                'equivalent' => '62',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '12.00',
                'equivalent' => '63',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '16.00',
                'equivalent' => '64',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '20.00',
                'equivalent' => '65',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '24.00',
                'equivalent' => '66',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '28.00',
                'equivalent' => '67',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '32.00',
                'equivalent' => '68',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '36.00',
                'equivalent' => '69',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '40.00',
                'equivalent' => '70',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '44.00',
                'equivalent' => '71',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '48.00',
                'equivalent' => '72',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '52.00',
                'equivalent' => '73',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '56.00',
                'equivalent' => '74',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '60.00',
                'equivalent' => '75',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '61.60',
                'equivalent' => '76',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '63.20',
                'equivalent' => '77',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '64.80',
                'equivalent' => '78',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '66.40',
                'equivalent' => '79',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '68.00',
                'equivalent' => '80',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '69.60',
                'equivalent' => '81',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '71.20',
                'equivalent' => '82',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '72.80',
                'equivalent' => '83',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '74.40',
                'equivalent' => '84',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '76.00',
                'equivalent' => '85',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '77.60',
                'equivalent' => '86',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '79.20',
                'equivalent' => '87',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '80.80',
                'equivalent' => '88',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '82.40',
                'equivalent' => '89',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '84.00',
                'equivalent' => '90',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '85.60',
                'equivalent' => '91',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '87.20',
                'equivalent' => '92',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '88.80',
                'equivalent' => '93',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '90.40',
                'equivalent' => '94',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '92.00',
                'equivalent' => '95',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '93.60',
                'equivalent' => '96',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '95.20',
                'equivalent' => '97',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '96.80',
                'equivalent' => '98',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '2',
                'score' => '98.40',
                'equivalent' => '99',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '2',
                'score' => '100.00',
                'equivalent' => '100',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '0.00',
                'equivalent' => '60',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '4.00',
                'equivalent' => '61',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '8.00',
                'equivalent' => '62',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '12.00',
                'equivalent' => '63',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '16.00',
                'equivalent' => '64',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '20.00',
                'equivalent' => '65',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '24.00',
                'equivalent' => '66',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '28.00',
                'equivalent' => '67',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '32.00',
                'equivalent' => '68',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '36.00',
                'equivalent' => '69',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '40.00',
                'equivalent' => '70',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '44.00',
                'equivalent' => '71',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '48.00',
                'equivalent' => '72',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '52.00',
                'equivalent' => '73',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '56.00',
                'equivalent' => '74',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '60.00',
                'equivalent' => '75',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '61.60',
                'equivalent' => '76',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '63.20',
                'equivalent' => '77',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '64.80',
                'equivalent' => '78',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '66.40',
                'equivalent' => '79',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '68.00',
                'equivalent' => '80',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '69.60',
                'equivalent' => '81',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '71.20',
                'equivalent' => '82',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '72.80',
                'equivalent' => '83',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '74.40',
                'equivalent' => '84',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '76.00',
                'equivalent' => '85',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '77.60',
                'equivalent' => '86',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '79.20',
                'equivalent' => '87',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '80.80',
                'equivalent' => '88',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '82.40',
                'equivalent' => '89',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '84.00',
                'equivalent' => '90',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '85.60',
                'equivalent' => '91',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '87.20',
                'equivalent' => '92',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '88.80',
                'equivalent' => '93',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '90.40',
                'equivalent' => '94',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '92.00',
                'equivalent' => '95',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '93.60',
                'equivalent' => '96',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '95.20',
                'equivalent' => '97',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '96.80',
                'equivalent' => '98',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '3',
                'score' => '98.40',
                'equivalent' => '99',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '3',
                'score' => '100.00',
                'equivalent' => '100',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '0.00',
                'equivalent' => '60',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '4.00',
                'equivalent' => '61',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '8.00',
                'equivalent' => '62',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '12.00',
                'equivalent' => '63',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '16.00',
                'equivalent' => '64',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '20.00',
                'equivalent' => '65',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '24.00',
                'equivalent' => '66',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '28.00',
                'equivalent' => '67',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '32.00',
                'equivalent' => '68',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '36.00',
                'equivalent' => '69',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '40.00',
                'equivalent' => '70',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '44.00',
                'equivalent' => '71',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '48.00',
                'equivalent' => '72',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '52.00',
                'equivalent' => '73',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '56.00',
                'equivalent' => '74',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '60.00',
                'equivalent' => '75',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '61.60',
                'equivalent' => '76',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '63.20',
                'equivalent' => '77',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '64.80',
                'equivalent' => '78',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '66.40',
                'equivalent' => '79',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '68.00',
                'equivalent' => '80',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '69.60',
                'equivalent' => '81',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '71.20',
                'equivalent' => '82',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '72.80',
                'equivalent' => '83',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '74.40',
                'equivalent' => '84',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '76.00',
                'equivalent' => '85',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '77.60',
                'equivalent' => '86',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '79.20',
                'equivalent' => '87',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '80.80',
                'equivalent' => '88',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '82.40',
                'equivalent' => '89',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '84.00',
                'equivalent' => '90',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '85.60',
                'equivalent' => '91',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '87.20',
                'equivalent' => '92',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '88.80',
                'equivalent' => '93',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '90.40',
                'equivalent' => '94',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '92.00',
                'equivalent' => '95',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '93.60',
                'equivalent' => '96',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '95.20',
                'equivalent' => '97',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '96.80',
                'equivalent' => '98',
                'created_by' => 1
            ], 
            [   
                'transmutation_id' => '4',
                'score' => '98.40',
                'equivalent' => '99',
                'created_by' => 1
            ],
            [   
                'transmutation_id' => '4',
                'score' => '100.00',
                'equivalent' => '100',
                'created_by' => 1
            ]
        ];

        foreach ($transmutations_elements as $transmutation_element) {
            DB::table('transmutations_elements')->insert($transmutation_element);
        }

        $education_types = [
            [   
                'id' => '1',
                'code' => 'early-childhood',
                'name' => 'Early Childhood',
                'description' => 'Early Childhood Description',
                'created_by' => 1
            ],
            [   
                'id' => '2',
                'code' => 'grade-school',
                'name' => 'Grade School',
                'description' => 'Grade School Description',
                'created_by' => 1
            ],
            [   
                'id' => '3',
                'code' => 'junior-highschool',
                'name' => 'Junior High School',
                'description' => 'Junior High School Description',
                'created_by' => 1
            ],
            [   
                'id' => '4',
                'code' => 'senior-highschool',
                'name' => 'Senior High School',
                'description' => 'Senior High School Description',
                'created_by' => 1
            ]
        ];
        foreach ($education_types as $education_type) {
            DB::table('education_types')->insert($education_type);
        }

        $messages_types = [
            [   
                'id' => '1',
                'code' => 'messaging',
                'name' => 'Messaging',
                'description' => 'Messaging',
                'created_by' => 1
            ],
            [   
                'id' => '2',
                'code' => 'soa',
                'name' => 'SOA',
                'description' => 'Statement of Account',
                'created_by' => 1
            ],
            [   
                'id' => '3',
                'code' => 'gradingsheet',
                'name' => 'Gradingsheet',
                'description' => 'Gradingsheet',
                'created_by' => 1
            ]
        ];
        foreach ($messages_types as $messages_type) {
            DB::table('messages_types')->insert($messages_type);
        }

        $prefixes = [
            [   
                'id' => '1',
                'access' => '222,2870,00905,0906,0915,0916,0917,0926,0927,0935,0936,0945,0955,0956,0965,0966,0967,0975,0976,0977,0978,0979,0994,0995,0997,08130937,0973,09173,09175,09176,09178,09253,09255,09256,09257,09258,0904',
                'network' => 'globe',
                'created_by' => 1
            ],
            [   
                'id' => '2',
                'access' => '0248,214,258,808,0813,0908,0911,0913,0914,0918,0919,0920,0921,0928,0929,0939,0947,0949,0961,0970,0981,0989,0998,0999,0907,0909,0910,0912,0930,0938,0946,0948,0950',
                'network' => 'smart',
                'created_by' => 1
            ],
            [   
                'id' => '3',
                'access' => '0922,0923,0924,0925,0931,0932,0933,0934,0941,0942,0943,0944',
                'network' => 'sun',
                'created_by' => 1
            ]
        ];
        foreach ($prefixes as $prefix) {
            DB::table('prefixes')->insert($prefix);
        }

        $payment_terms = [
            [
                'code' => "Whole Year / Annual or Cash Basis",
                'name' => "Whole Year / Annual or Cash Basis",
                'description' => "Whole Year / Annual or Cash Basis",
                'created_by' => 1
            ], 
            [
                'code' => "Semestral",
                'name' => "Semestral",
                'description' => "Semestral",
                'created_by' => 1
            ], 
            [
                'code' => "Monthly Option 1",
                'name' => "Monthly Option 1",
                'description' => "Monthly Option 1",
                'created_by' => 1
            ], 
            [
                'code' => "Monthly Option 2",
                'name' => "Monthly Option 2",
                'description' => "Monthly Option 2",
                'created_by' => 1
            ]
        ];
        foreach ($payment_terms as $payment_term) {
            DB::table('payment_terms')->insert($payment_term);
        }

        $payment_options = [
            [
                'code' => "Online (I will pay thru online banking or deposit payment to bank)",
                'name' => "Online (I will pay thru online banking or deposit payment to bank)",
                'description' => "Online (I will pay thru online banking or deposit payment to bank)",
                'created_by' => 1
            ], 
            [
                'code' => "Onsite (I will pay in the school Cashier's Office)",
                'name' => "Onsite (I will pay in the school Cashier's Office)",
                'description' => "Onsite (I will pay in the school Cashier's Office)",
                'created_by' => 1
            ]
        ];
        foreach ($payment_options as $payment_option) {
            DB::table('payment_options')->insert($payment_option);
        }

        $levels = [
            [
                'code' => "nursery",
                'name' => "Nursery",
                'description' => "Nursery (4 years old by October 31)",
                'education_type_id' => 1,
                'created_by' => 1
            ], 
            [
                'code' => "kinder",
                'name' => "Kinder",
                'description' => "Kinder (5 years old by October 31)",
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'code' => "grade-1",
                'name' => "Grade 1",
                'description' => "Grade 1 (6 years old by October 31)",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-2",
                'name' => "Grade 2",
                'description' => "Grade 2",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-3",
                'name' => "Grade 3",
                'description' => "Grade 3",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-4",
                'name' => "Grade 4",
                'description' => "Grade 4",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-5",
                'name' => "Grade 5",
                'description' => "Grade 5",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-6",
                'name' => "Grade 6",
                'description' => "Grade 6",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-7",
                'name' => "Grade 7",
                'description' => "Grade 7",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-8",
                'name' => "Grade 8",
                'description' => "Grade 8",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-9",
                'name' => "Grade 9",
                'description' => "Grade 9",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "grade-10",
                'name' => "Grade 10",
                'description' => "Grade 10",
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'code' => "junior-high",
                'name' => "Junior High",
                'description' => "Junior High",
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'code' => "senior-high",
                'name' => "Senior High",
                'description' => "Senior High",
                'education_type_id' => 4,
                'created_by' => 1
            ]
        ];
        foreach ($levels as $level) {
            DB::table('levels')->insert($level);
        }

        $materials = [
            [
                'code' => "substance",
                'name' => "Substance",
                'description' => "Substance Description",
                'created_by' => 1
            ], 
            [
                'code' => "conduct",
                'name' => "Conduct",
                'description' => "Conduct Description",
                'created_by' => 1
            ], 
            [
                'code' => "homeroom",
                'name' => "Homeroom",
                'description' => "Homeroom Description",
                'created_by' => 1
            ], 
            [
                'code' => "co-curricular",
                'name' => "Co-curricular",
                'description' => "Co-curricular Description",
                'created_by' => 1
            ]
        ];
        foreach ($materials as $material) {
            DB::table('materials')->insert($material);
        }

        $subjects = [
            [
                'code' => "CLEd",
                'name' => "CLEd",
                'description' => "CLEd Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 1,
                'created_by' => 1
            ],
            [
                'code' => "Fil",
                'name' => "Filipino",
                'description' => "Filipino Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 2,
                'created_by' => 1
            ],
            [
                'code' => "Eng",
                'name' => "English",
                'description' => "English Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 3,
                'created_by' => 1
            ],
            [
                'code' => "Math",
                'name' => "Mathematics",
                'description' => "Mathematics Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 4,
                'created_by' => 1
            ],
            [
                'code' => "Sci",
                'name' => "Science and Health",
                'description' => "Science and Health Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 5,
                'created_by' => 1
            ],
            [
                'code' => "AP",
                'name' => "Araling Panlipunan",
                'description' => "Araling Panlipunan Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 6,
                'created_by' => 1
            ],
            [
                'code' => "Music",
                'name' => "Music",
                'description' => "Music Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 1,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 7,
                'created_by' => 1
            ],
            [
                'code' => "Arts",
                'name' => "Arts",
                'description' => "Arts Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 1,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 8,
                'created_by' => 1
            ],
            [
                'code' => "PE",
                'name' => "Physical Education",
                'description' => "Physical Education Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 1,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 9,
                'created_by' => 1
            ],
            [
                'code' => "Health",
                'name' => "Health",
                'description' => "Health Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 1,
                'is_tle' => 0,
                'material_id' => 1,
                'order' => 10,
                'created_by' => 1
            ],
            [
                'code' => "ICT",
                'name' => "ICT",
                'description' => "ICT Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 1,
                'material_id' => 1,
                'order' => 11,
                'created_by' => 1
            ],
            [
                'code' => "LE",
                'name' => "LE",
                'description' => "LE Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 1,
                'material_id' => 1,
                'order' => 12,
                'created_by' => 1
            ],
            [
                'code' => "Conduct",
                'name' => "Conduct",
                'description' => "Conduct Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 2,
                'order' => 13,
                'created_by' => 1
            ],
            [
                'code' => "Homeroom",
                'name' => "Homeroom",
                'description' => "Homeroom Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 3,
                'order' => 14,
                'created_by' => 1
            ],
            [
                'code' => "Co-curricular",
                'name' => "Co-curricular",
                'description' => "Co-curricular Description",
                'coordinator_id' => NULL,
                'is_mapeh' => 0,
                'is_tle' => 0,
                'material_id' => 4,
                'order' => 15,
                'created_by' => 1
            ]
        ];
        foreach ($subjects as $subject) {
            DB::table('subjects')->insert($subject);
        }

        $subject_education_types = [
            [
                'subject_id' => 1,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 1,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 1,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 1,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 2,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 2,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 2,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 2,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 3,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 3,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 3,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 3,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 4,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 4,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 4,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 4,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 5,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 5,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 5,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 5,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 6,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 6,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 6,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 6,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 7,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 7,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 7,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 7,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 8,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 8,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 8,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 8,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 9,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 9,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 9,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 9,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 10,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 10,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 10,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 10,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 11,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 11,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 11,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 11,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 12,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 12,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 12,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 12,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 13,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 13,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 13,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 13,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 14,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 14,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 14,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 14,
                'education_type_id' => 4,
                'created_by' => 1
            ],
            [
                'subject_id' => 15,
                'education_type_id' => 1,
                'created_by' => 1
            ],
            [
                'subject_id' => 15,
                'education_type_id' => 2,
                'created_by' => 1
            ],
            [
                'subject_id' => 15,
                'education_type_id' => 3,
                'created_by' => 1
            ],
            [
                'subject_id' => 15,
                'education_type_id' => 4,
                'created_by' => 1
            ],
        ];
        foreach ($subject_education_types as $subject_education_type) {
            DB::table('subjects_education_types')->insert($subject_education_type);
        }

        $preset_messages = [
            [
                'message' => 'Infoblast: <DATE> YOUR CHILD <STUD_NAME> HAS SAFELY ARRIVED AT CAMPUS <TIME>.',
                'created_by' => 1
            ],
            [
                'message' => 'Infoblast: <DATE> YOUR CHILD <STUD_NAME> HAS LEFT CAMPUS <TIME>.',
                'created_by' => 1
            ],
            [
                'message' => 'Infoblast: <DATE> YOUR CHILD <STUD_NAME> HAS LEFT CAMPUS <TIME>.',
                'created_by' => 1
            ],
            [
                'message' => 'Infoblast: <DATE> YOUR CHILD <STUD_NAME> HAS SAFELY ARRIVED AT CAMPUS <TIME>.',
                'created_by' => 1
            ],
            [
                'message' => 'Infoblast: <DATE> YOUR CHILD <STUD_NAME> HAS LEFT CAMPUS <TIME>.',
                'created_by' => 1
            ],
            [
                'message' => 'Infoblast: <DATE> YOUR CHILD <STUD_NAME> LEFT/ENTERED CAMPUS <TIME>.',
                'created_by' => 1
            ]
        ];
        foreach ($preset_messages as $preset_message) {
            DB::table('preset_messages')->insert($preset_message);
        }

    }
}
