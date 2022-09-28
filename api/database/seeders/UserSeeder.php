<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'rol_id'   => 1,
            'name'     => 'Administrador',
            'email'    => 'administrador@test.com',
            'password' =>  Hash::make(1234)
        ]);

        User::create([
            'rol_id'   => 2,
            'name'     => 'UserPrueba',
            'email'    => 'User@test.com',
            'password' =>  Hash::make(1234)
        ]);
    	// User::factory(20)->create();
    }
}
