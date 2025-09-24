<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Book::factory(15)->create();

        User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@gmail.com',
            'username' => 'testeruser',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'nama' => 'Tester User',
            'email' => 'tester@gmail.com',
            'username' => 'Tester002',
            'password' => bcrypt('password'),
            'role' => 'petugas',
        ]);
    }
}
