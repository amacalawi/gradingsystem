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
                'code' => 'section-student',
                'name' => 'Classes',
                'description' => 'Classes Description',
                'slug' => 'section-student',
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
                'code' => 'components',
                'name' => 'Components',
                'description' => 'Components Description',
                'slug' => 'components',
                'icon' => '',
                'order' => '6',
                'created_by' => 1
            ],
            [   
                'module_id' => '3',
                'code' => 'transmutations',
                'name' => 'Transmutations',
                'description' => 'Transmutations Description',
                'slug' => 'transmutations',
                'icon' => '',
                'order' => '7',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'student-attendance',
                'name' => 'Student Attendance',
                'description' => 'Student Attendance Description',
                'slug' => 'student-attendance',
                'icon' => '',
                'order' => '8',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'staff-attendance',
                'name' => 'Staff Attendance',
                'description' => 'Staff Attendance Description',
                'slug' => 'staff-attendance',
                'icon' => '',
                'order' => '9',
                'created_by' => 1
            ],
            [   
                'module_id' => '4',
                'code' => 'attendance-report',
                'name' => 'Attendance Report',
                'description' => 'Attendance Report Description',
                'slug' => 'attendance-report',
                'icon' => '',
                'order' => '10',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'batches',
                'name' => 'Batches',
                'description' => 'Batches Description',
                'slug' => 'batches',
                'icon' => '',
                'order' => '11',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'quarters',
                'name' => 'Quaraters',
                'description' => 'Quaraters Description',
                'slug' => 'quarters',
                'icon' => '',
                'order' => '12',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'departments',
                'name' => 'Departments',
                'description' => 'Departments Description',
                'slug' => 'departments',
                'icon' => '',
                'order' => '13',
                'created_by' => 1
            ],
            [   
                'module_id' => '5',
                'code' => 'designations',
                'name' => 'Designations',
                'description' => 'Designations Description',
                'slug' => 'designations',
                'icon' => '',
                'order' => '14',
                'created_by' => 1
            ],
            [   
                'module_id' => '6',
                'code' => 'all-active-groups',
                'name' => 'All Active Groups',
                'description' => 'All Active Groups Description',
                'slug' => 'active',
                'icon' => '',
                'order' => '15',
                'created_by' => 1
            ],
            [   
                'module_id' => '6',
                'code' => 'all-inactive-groups',
                'name' => 'All Inactive Groups',
                'description' => 'All Inactive Groups Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '16',
                'created_by' => 1
            ],
            [   
                'module_id' => '7',
                'code' => 'all-active-schedules',
                'name' => 'All Active Schedules',
                'description' => 'All Active Schedules Description',
                'slug' => 'active',
                'icon' => '',
                'order' => '17',
                'created_by' => 1
            ],
            [   
                'module_id' => '7',
                'code' => 'all-inactive-schedules',
                'name' => 'All Inactive Schedules',
                'description' => 'All Inactive Schedules Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '18',
                'created_by' => 1
            ],
            [   
                'module_id' => '8',
                'code' => 'headers',
                'name' => 'Headers',
                'description' => 'Headers Description',
                'slug' => 'headers',
                'icon' => '',
                'order' => '19',
                'created_by' => 1
            ],
            [   
                'module_id' => '8',
                'code' => 'modules',
                'name' => 'Modules',
                'description' => 'Modules Description',
                'slug' => 'modules',
                'icon' => '',
                'order' => '20',
                'created_by' => 1
            ],
            [   
                'module_id' => '8',
                'code' => 'sub-modules',
                'name' => 'Sub Modules',
                'description' => 'Sub Modules Description',
                'slug' => 'sub-modules',
                'icon' => '',
                'order' => '21',
                'created_by' => 1
            ],
            [   
                'module_id' => '9',
                'code' => 'all-active-students',
                'name' => 'All Active Students',
                'description' => 'All Active Students Description',
                'slug' => 'active',
                'icon' => '',
                'order' => '22',
                'created_by' => 1
            ],
            [   
                'module_id' => '9',
                'code' => 'all-inactive-students',
                'name' => 'All Inactive Students',
                'description' => 'All Inactive Students Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '23',
                'created_by' => 1
            ],
            [   
                'module_id' => '10',
                'code' => 'all-active-staffs',
                'name' => 'All Active Staffs',
                'description' => 'All Active Staffs Description',
                'slug' => 'active',
                'icon' => '',
                'order' => '24',
                'created_by' => 1
            ],
            [   
                'module_id' => '10',
                'code' => 'all-inactive-staffs',
                'name' => 'All Inactive Staffs',
                'description' => 'All Inactive Staffs Description',
                'slug' => 'inactive',
                'icon' => '',
                'order' => '25',
                'created_by' => 1
            ],
            [   
                'module_id' => '11',
                'code' => 'accounts',
                'name' => 'Accounts',
                'description' => 'Accounts Description',
                'slug' => 'accounts',
                'icon' => '',
                'order' => '26',
                'created_by' => 1
            ],
            [   
                'module_id' => '11',
                'code' => 'roles-and-permissions',
                'name' => 'Roles And Permissions',
                'description' => 'Roles And Permissions Description',
                'slug' => 'roles-and-permissions',
                'icon' => '',
                'order' => '27',
                'created_by' => 1
            ],
            [   
                'module_id' => '12',
                'code' => 'send-message',
                'name' => 'Send Message',
                'description' => 'Send Message Description',
                'slug' => 'send-message',
                'icon' => '',
                'order' => '28',
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
            ]
        ];

        foreach ($roles_sub_modules as $roles_sub_module) {
            DB::table('roles_sub_modules')->insert($roles_sub_module);
        }
    }
}
