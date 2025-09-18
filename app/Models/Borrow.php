<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        "tgl_pinjam",
        "tgl_kembali",
        "status_buku",
    ];

    /**
     * Get the books which can borrow
     */
    public function book() {
        return $this->belongsTo(Book::class);
    }

    /**
     * Informasi siapa yang meminjam
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
