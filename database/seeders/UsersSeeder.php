<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->whereIn('email', ['admin@email.com', 'operador@email.com', 'comum@email.com'])->delete();

        DB::table('users')->insert([
            [
                'name'       => 'Usuário Admin',
                'email'      => 'admin@email.com',
                'level'      => 'admin',
                'password'   => Hash::make('teste123'),
                'created_at' => now(),
            ],
            [
                'name'       => 'Usuário Operador',
                'email'      => 'operador@email.com',
                'level'      => 'operator',
                'password'   => Hash::make('teste123'),
                'created_at' => now(),
            ],
            [
                'name'       => 'Usuário Comum',
                'email'      => 'comum@email.com',
                'level'      => 'common',
                'password'   => Hash::make('teste123'),
                'created_at' => now(),
            ],
        ]);
    }
}
