<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Borrow;
use Illuminate\Validation\Rule;

class UserBorrowForm extends Form
{
    public $book_id = null;
    public $user_id = null;
    public $tgl_pinjam = '';
    public $kode_pinjam = null;

    /**
     * Validation rules
     */
    protected function rules() {
        return [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'kode_pinjam' => [
                'required',
                'string',
                Rule::unique('borrows', 'kode_pinjam')
            ]
        ];
    }

    /**
     * Store data
     */
    public function store() {
        $this->validate();

        Borrow::create($this->all());
    }
}
