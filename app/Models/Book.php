<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        "judul",
        "ISBN",
        "penulis",
        "penerbit",
        "tahun_terbit",
        "kondisi",
        "foto_samplul",
        "jml_pinjam"
    ];

    /**
     * Get the books which is lent
     */
    public function borrows() {
        return $this->hasMany(Borrow::class);
    }
}
