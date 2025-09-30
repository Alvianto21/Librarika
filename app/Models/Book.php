<?php

namespace App\Models;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, Sluggable;

    protected $fillable = [
        "judul",
        "ISBN",
        "penulis",
        "penerbit",
        "tahun_terbit",
        "kondisi",
        "foto_samplul",
        "jml_pinjam",
        'slug',
        'deskripsi'
    ];

    /**
     * Get the books which is lent
     */
    public function borrows() {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Scope a query to search books.
     */
    public function scopeSearch(Builder $query, $search) {
        return $query->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('penulis', 'like', '%' . $search . '%')
                    ->orWhere('penerbit', 'like', '%' . $search . '%')
                    ->orWhere('tahun_terbit', 'like', '%' . $search . '%')
                    ->orWhere('ISBN', 'like', '%' . $search . '%');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    /**
     * Return date format for tahun_terbit to be d-m-Y
     */
    public function formatedTahunTerbit() {
        return Carbon::parse($this->tahun_terbit)->format('d-m-Y');
    }
}
