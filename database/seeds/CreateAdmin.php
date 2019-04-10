<?php

use Illuminate\Database\Seeder;

class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gets the ID of role admin
    	$role =  DB::table('available_roles')->where('role', "admin")->first();

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret_password'),
        ]);

        // Gives the admin role to our first admin user
        DB::table('current_roles')->insert([
            'user_id' => DB::getPdo()->lastInsertId(),
            'role_id' => $role->id,
        ]);

    }
}
