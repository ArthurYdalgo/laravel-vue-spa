<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');
        
        $faker->seed(616);

        for ($i=0; $i < 10; $i++) { 
            
            $user_data = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('senha_padrao')
            ];

            $user = User::create($user_data);            
            
            $user->assignRole('user');
        }
    }
}
