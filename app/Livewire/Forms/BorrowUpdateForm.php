<?php

namespace App\Livewire\Forms;

use App\Models\Borrow;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BorrowUpdateForm extends Form
{
    public ?Borrow $borrow;

    public $book_id = null;
    public $user_id = null;
    public $kode_pinjam = '';
    public $tgl_pinjam = '';
    public $tgl_kembali = null;
    public $status_pinjam = '';

    /**
     * Validation rules
     */
    public function rules() {
        return [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date|before_or_equal:tgl_pinjam',
            'tgl_kembali' => 'nullable|date|required_if:status_pinjam,dikembalikan,hilang,terlambat|after_or_equal:tgl_pinjam',
            'status_pinjam' => 'required|in:dikembalikan,dipinjam,hilang,termabat',
            'kode_pinjam' => [
                'required',
                'string',
                Rule::unique('borrows', 'kode_pinjam')->ignore($this->borrow->id)
            ]
        ];
    }

    /**
     * Set defaults value
     */
    public function setBorrow(Borrow $borrow) {
        $this->borrow = $borrow;

        $this->book_id = $borrow->book->id;
        $this->user_id = $borrow->user->id;
        $this->kode_pinjam = $borrow->kode_pinjam;
        $this->tgl_pinjam = $borrow->tgl_pinjam;
        $this->tgl_kembali = $borrow->tgl_kembali;
        $this->status_pinjam = $borrow->status_pinjam;
    }

    /**
     * Update borrow
     */
    public function update() {
        $validate = $this->validate();

        $this->borrow->update($validate);
    }
}
