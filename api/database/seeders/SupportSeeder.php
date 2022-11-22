<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Support;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Support::create([
            'user_id'   => 1,
            'name'     => 'prueba',
            'email'    => 'administrador@test.com',
            'categories' =>  0,
            'priority' => 1,
            'status' => 0,
            'issue' => 'prueba'
        ]);

        Support::create([
            'user_id'   => 2,
            'name'     => 'prueba',
            'email'    => 'User@test.com',
            'categories' =>  0,
            'priority' => 1,
            'status' => 0,
            'issue' => 'prueba'
        ]);
    }
}
