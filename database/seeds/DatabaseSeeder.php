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
                'icon' => 'fa fa-calendar',
                'order' => '7',
                'created_by' => 1
            ],
            [   
                'header_id' => '2',
                'code' => 'menus',
                'name' => 'Menus',
                'description' => 'Menus Description',
                'slug' => 'menus',
                'icon' => 'fa fa-list',
                'order' => '8',
                'created_by' => 1
            ],
            [   
                'header_id' => '3',
                'code' => 'students',
                'name' => 'Students',
                'description' => 'Students Description',
                'slug' => 'students',
                'icon' => 'la la-user',
                'order' => '9',
                'created_by' => 1
            ],
            [   
                'header_id' => '3',
                'code' => 'staffs',
                'name' => 'Staffs',
                'description' => 'Staffs Description',
                'slug' => 'staffs',
                'icon' => 'fa fa-user-secret',
                'order' => '10',
                'created_by' => 1
            ],
            [   
                'header_id' => '3',
                'code' => 'users',
                'name' => 'Users',
                'description' => 'Users Description',
                'slug' => 'users',
                'icon' => 'la la-users',
                'order' => '11',
                'created_by' => 1
            ],
            [   
                'header_id' => '4',
                'code' => 'messaging',
                'name' => 'Messaging',
                'description' => 'Messaging Description',
                'slug' => 'messaging',
                'icon' => 'la la-comments',
                'order' => '12',
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
                'order' => '4',
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
                'code' => 'batches',
                'name' => 'Batches',
                'description' => 'Batches Description',
                'slug' => 'batches',
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
                'name' => 'Manage All Groups',
                'description' => 'Manage All Groups Description',
                'slug' => '',
                'icon' => '',
                'order' => '17',
                'created_by' => 1
            ],
            [   
                'module_id' => '6',
                'code' => 'manage-all-inactive-groups',
                'name' => 'Manage All Inactive Groups',
                'description' => 'Manage All Inactive Groups Description',
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
                'code' => 'headers',
                'name' => 'Headers',
                'description' => 'Headers Description',
                'slug' => 'headers',
                'icon' => '',
                'order' => '22',
                'created_by' => 1
            ],
            [   
                'module_id' => '8',
                'code' => 'modules',
                'name' => 'Modules',
                'description' => 'Modules Description',
                'slug' => 'modules',
                'icon' => '',
                'order' => '23',
                'created_by' => 1
            ],
            [   
                'module_id' => '8',
                'code' => 'sub-modules',
                'name' => 'Sub Modules',
                'description' => 'Sub Modules Description',
                'slug' => 'sub-modules',
                'icon' => '',
                'order' => '24',
                'created_by' => 1
            ],
            [   
                'module_id' => '9',
                'code' => 'all-active-students',
                'name' => 'All Active Students',
                'description' => 'All Active Students Description',
                'slug' => '',
                'icon' => '',
                'order' => '25',
                'created_by' => 1
            ],
            [   
                'module_id' => '9',
                'code' => 'all-inactive-students',
                'name' => 'All Inactive Students',
                'description' => 'All Inactive Students Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '26',
                'created_by' => 1
            ],
            [   
                'module_id' => '10',
                'code' => 'all-active-staffs',
                'name' => 'All Active Staffs',
                'description' => 'All Active Staffs Description',
                'slug' => '',
                'icon' => '',
                'order' => '27',
                'created_by' => 1
            ],
            [   
                'module_id' => '10',
                'code' => 'all-inactive-staffs',
                'name' => 'All Inactive Staffs',
                'description' => 'All Inactive Staffs Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '28',
                'created_by' => 1
            ],
            [   
                'module_id' => '11',
                'code' => 'accounts',
                'name' => 'Accounts',
                'description' => 'Accounts Description',
                'slug' => 'accounts',
                'icon' => '',
                'order' => '29',
                'created_by' => 1
            ],
            [   
                'module_id' => '11',
                'code' => 'roles-and-permissions',
                'name' => 'Roles And Permissions',
                'description' => 'Roles And Permissions Description',
                'slug' => 'roles',
                'icon' => '',
                'order' => '30',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'infoblast',
                'name' => 'Infoblast',
                'description' => 'Infoblast Description',
                'slug' => 'infoblast',
                'icon' => '',
                'order' => '31',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'emailblast',
                'name' => 'Emailblast',
                'description' => 'Emailblast Description',
                'slug' => 'emailblast',
                'icon' => '',
                'order' => '32',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'systemblast',
                'name' => 'Systemblast',
                'description' => 'Systemblast Description',
                'slug' => 'systemblast',
                'icon' => '',
                'order' => '33',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'configuration',
                'name' => 'Configuration',
                'description' => 'Configuration Description',
                'slug' => 'configuration',
                'icon' => '',
                'order' => '34',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'education-types',
                'name' => 'Education Types',
                'description' => 'Education Types',
                'slug' => 'education-types',
                'icon' => '',
                'order' => '35',
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

        
    }
}
