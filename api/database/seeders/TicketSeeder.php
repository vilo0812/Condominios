<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ticket::create([
            'user_id'   => 1,
            'name'     => 'prueba',
            'email'    => 'administrador@test.com',
            'categories' =>  0,
            'priority' => 1,
            'status' => 0,
            'issue' => 'prueba'
        ]);

        Ticket::create([
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
