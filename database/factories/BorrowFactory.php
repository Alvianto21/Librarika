<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrow;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * The name factory's corresponding models
     * 
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Borrow::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'tgl_pinjam' => fake()->dateTimeBetween('-1 month', 'now'),
            'tgl_kembali' => fake()->dateTimeBetween('-3 weeks', '+2 weeks'),
            'status_pinjam' => fake()->randomElement(['dipinjam', 'dikembalikan', 'hilang', 'terlambat']),
            'kode_pinjam' => 'TXBOR-' .  Str::uuid()->toString()
        ];
    }
}
