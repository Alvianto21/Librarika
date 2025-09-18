<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->words(4, true),
            'ISBN' => fake()->unique()->isbn13(),
            'penulis' => fake()->name(),
            'tahun_terbit' => fake()->year(),
            'kondisi' => fake()->randomElement(['bagus', 'kusam', 'sampul rusak']),
            'jml_pinjam' => fake()->randomNumber(2, false),
        ];
    }
}
