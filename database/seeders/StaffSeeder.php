<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_data = [
            'name' => 'Master',
            'email' => 'master@email.com',
            'password' => Hash::make('senha123')
        ];                

        $master = User::create($user_data);

        $master->assignRole('master');

        $user_data = [
            'name' => 'Administrator',
            'email' => 'adm@email.com',
            'password' => Hash::make('senha123')
        ];        

        $administrator = User::create($user_data);

        $administrator->assignRole('administrator');

        $user_data = [
            'name' => 'Moderator',
            'email' => 'mod@email.com',
            'password' => Hash::make('senha123')
        ];        

        $moderator = User::create($user_data);

        $moderator->assignRole('moderator');
    }
}
