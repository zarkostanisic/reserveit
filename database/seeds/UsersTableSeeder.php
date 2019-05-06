<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

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
            'api_token' => Str::random(60),
	        'remember_token' => Str::random(10),
            'city_id' => 1,
	        'role_id' => 1,
            'company_id' => 0
    	]);

    	User::create([
    		'name' => 'Manager',
	        'email' => 'manager@reserveit.com',
	        'email_verified_at' => now(),
	        'password' => bcrypt('manager'),
            'api_token' => Str::random(60),
	        'remember_token' => Str::random(10),
            'city_id' => 2,
	        'role_id' => 2,
            'company_id' => 1
    	]);

    	User::create([
    		'name' => 'Hostess',
	        'email' => 'hostess@reserveit.com',
	        'email_verified_at' => now(),
	        'password' => bcrypt('hostess'),
            'api_token' => Str::random(60),
	        'remember_token' => Str::random(10),
            'city_id' => 3,
	        'role_id' => 3,
            'company_id' => 2
    	]);

        factory(User::class, 100)->create();
    }
}
