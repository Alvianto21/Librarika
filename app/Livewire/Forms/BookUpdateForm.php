<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class BookUpdateForm extends Form
{
    public ?Book $book;
    
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
            'kondisi' => 'required|in:Bagus,Kusam,Rusak',
            'deskripsi' => 'nullable|string',
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('books', 'slug')->ignore($this->book->id),
            ],
            'ISBN' => [
                'required',
                'numeric',
                'digits_between:10,13',
                Rule::unique('books', 'ISBN')->ignore($this->book->id),
            ]
        ];
    }

    /**
     * Update book
     */
    public function update() {
        // Validate input
        $this->validate();

        // if foto sampul exist, delete it and store new one
        if ($this->foto_sampul instanceof \Illuminate\Http\UploadedFile) {
            if (!empty($this->book->foto_sampul)) {
                Storage::disk('public')->delete($this->book->foto_sampul);
            }

            $this->foto_sampul = $this->foto_sampul->store('sampul-buku', 'public');
        }

        $this->book->update($this->all());
    }

    /**
     * Set inisial data
     */
    public function setBook(Book $book) {
        $this->book = $book;

        $this->judul = $book->judul;
        $this->slug = $book->slug;
        // $this->foto_sampul = $book->foto_sampul;
        $this->penerbit = $book->penerbit;
        $this->penulis = $book->penulis;
        $this->ISBN = $book->ISBN;
        $this->tahun_terbit = $book->tahun_terbit;
        $this->deskripsi = $book->deskripsi;
        $this->kondisi = $book->kondisi;
    }

}
