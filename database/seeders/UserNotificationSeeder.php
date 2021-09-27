<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\UserNotificationService;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class UserNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $faker = Faker::create('pt_BR');
        
        $faker->seed(616);        

        foreach($users as $user){
            $user_notification_service = new UserNotificationService($user);

            for ($i=0; $i < random_int(1,10); $i++) { 
                $user_notification_service->notify($faker->text(20), $faker->text(100), $faker->randomElement(['cog', 'exclamation-triangle', 'radiation', 'comment', 'share', 'thumbs-up',null]));                
            }
        }
    }
}
