<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Appointment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Cria o primeiro Recepcionista
        User::create([
            'name' => 'Jeff Recepcionista',
            'email' => 'jeff@recepcionista.com',
            'password' => Hash::make('12345678'), 
            'user_type' => 'R', 
        ]);

        // Cria o primeiro Médico
        User::create([
            'name' => 'Jeff Médico',
            'email' => 'jeff@doctor.com',
            'password' => Hash::make('12345678'), 
            'user_type' => 'D', 
        ]);
        
        // Cria o primeiro agendamento
        Appointment::create([
            "client_name" => "Jeff agendamento 1",
            "email" => "jeff@test1.com",
            "animal_name" => "grafite",
            "animal_type" => "D",
            "age" => 10,
            "symptoms" => "dor de cabeça",
            "appointment_date" => "2024-08-02 01:37:17",
            "period" => "M",
            "user_id" => 2 
        ]);

        User::factory(10)->create();
        Appointment::factory(10)->create();
        
    }
}
