<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Solo crear el usuario si no existe
        if (!User::where('email', 'admin@distrijarca.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@distrijarca.com',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
                'role' => 'super_admin',
                'activo' => true,
            ]);
        }
    }
}
