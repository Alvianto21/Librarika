<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Book;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class BookForm extends Form
{
    
    public $judul = '';
    public $penulis = '';
    public $penerbit = null;
    public $deskripsi = '';
    public $kondisi = '';
    public $tahun_terbit = null;

    #[Validate]
    public $foto_sampul = '';

    #[Validate]
    public $slug = '';

    #[validate]
    public $ISBN = null;

    /**
     * Validation rules
     */
    protected function rules() {
        return [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|date_format:Y-m-d',
            'foto_sampul' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'kondisi' => 'required|in:bagus,kusam,rusak',
            'deskripsi' => 'nullable|string',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('books', 'slug'),
            ],
            'ISBN' => [
                'required',
                'numeric',
                'digits_between:10,13',
                Rule::unique('books', 'ISBN'),
            ]
        ];
    }

    /**
     * Store new book
     */
    public function store() {
        // Validate input
        $this->validate();

        // Store foto sampul if exist
        if ($this->foto_sampul instanceof \Illuminate\Http\UploadedFile) {
            $this->foto_sampul = $this->foto_sampul->store('sampul-buku', 'public');
        }

        Book::create($this->all());
    }
}
