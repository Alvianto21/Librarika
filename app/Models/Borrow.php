<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\BorrowFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Livewire\Volt\uses;

class Borrow extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "tgl_pinjam",
        "tgl_kembali",
        "status_pinjam",
        'kode_pinjam',
        'user_id',
        'book_id'
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
        return $query->where('status_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('kode_pinjam', 'like' , '%' . $search . '%')
                    ->orWhere('tgl_pinjam', 'like', '%' . $search . '%')
                    ->orWhere('tgl_kembali', 'like', '%' . $search . '%')
                    ->orwhereHas('book', fn($q) => 
                        $q->where('judul', 'like', '%' . $search . '%'))
                    ->orWhereHas('user', fn($q) =>
                        $q->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                    );
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
