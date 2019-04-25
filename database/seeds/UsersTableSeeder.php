<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
    		'name' => 'Administrator',
	        'email' => 'administrator@reserveit.com',
	        'email_verified_at' => now(),
	        'password' => bcrypt('administrator'),
	        'remember_token' => Str::random(10),
	        'role_id' => 1
    	]);

    	User::create([
    		'name' => 'Manager',
	        'email' => 'manager@reserveit.com',
	        'email_verified_at' => now(),
	        'password' => bcrypt('manager'),
	        'remember_token' => Str::random(10),
	        'role_id' => 2
    	]);

    	User::create([
    		'name' => 'Hostess',
	        'email' => 'hostess@reserveit.com',
	        'email_verified_at' => now(),
	        'password' => bcrypt('hostess'),
	        'remember_token' => Str::random(10),
	        'role_id' => 3
    	]);

        factory(User::class, 100)->create();
    }
}
