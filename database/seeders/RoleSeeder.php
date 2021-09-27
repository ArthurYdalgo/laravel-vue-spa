<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        createRole('master');

        createRole('administrator');

        createRole('moderator');

        createRole('user');
    }
}
