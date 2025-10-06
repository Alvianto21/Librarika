<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\BorrowFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    
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

    /**
     * Scipe a query to search borrows
     */
    public function scopeSearch(Builder $query, $search) {
        return $query->where('username', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like' , '%' . $search . '%')
                    ->orWhere('status_buku', 'like', '%' . $search . '%')
                    ->orWhere('judul', 'like', '%', $search . '%');
    }

    /**
     * Return date format to d-m-Y
     */
    public function formattdDate($date) {
        return Carbon::parse($date)->format('d-m-Y');
    }

    /**
    * Create a new factory instance for the model.
    */
    protected static function newFactory()
    {
        return BorrowFactory::new();
    }
}
