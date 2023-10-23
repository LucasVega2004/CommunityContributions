<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('channels')->insert([
            'title' => 'Python',
            'slug' => 'Python',
            'color' => 'purple' // Puedes usar bcrypt para cifrar la contraseña
        ]);
        DB::table('channels')->insert([
            'title' => 'JavaScript',
            'slug' => 'JavaScript',
            'color' => 'yellow' // Puedes usar bcrypt para cifrar la contraseña
        ]);
        DB::table('channels')->insert([
            'title' => 'PHP',
            'slug' => 'PHP',
            'color' => 'blue' // Puedes usar bcrypt para cifrar la contraseña
        ]);

    }
}
