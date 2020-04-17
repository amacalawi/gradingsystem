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
        // $this->call(UsersTableSeeder::class);

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin',
            'username' => 'superadmin',
            'password' => '$2y$10$mEzN8zr327/0Qp/GebqspOik64vXbnfiuala5n6bnUxpAvvS9Ndni',
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

        $members_types = [
            [
                'code' => 'student',
                'name' => 'Student',
                'description' => 'Student Type',
                'created_by' => 1
            ], 
            [
                'code' => 'staff',
                'name' => 'Staff',
                'description' => 'Staff Type',
                'created_by' => 1
            ],
            [
                'code' => 'parent',
                'name' => 'Parent',
                'description' => 'Parent Type',
                'created_by' => 1
            ]
        ];
        foreach ($members_types as $members_type) {
            DB::table('members_types')->insert($members_type);
        }
    }
}
