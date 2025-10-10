<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Livewire\Forms\BorrowUpdateForm;
use App\Models\Book;
use App\Models\Borrow;
use Livewire\Component;
use Livewire\Attributes\Layout;

class EditBorrow extends Component
{
    public BorrowUpdateForm $form;
    public $books;

    /**
     * Clas constructor
     */
    public function mount(Borrow $borrow) {
        // Autorize
        $this->authorize('update', $borrow);

        // Set defaults value
        $this->form->setBorrow($borrow);
        $this->books = Book::select('id', 'judul')->get();
    }

    /**
     * Submit form
     */
    public function save() {
        $this->form->update();

        session()->flash('BorrowUpdateSuccess', 'Data peminjaman berhasil diperbarui');
        $this->redirectRoute('borrow.index');
    }
    
    #[Layout("components.dashboard.layout", ["title" => "Edit Data Pinjam"])]
    
    public function render()
    {
        return view('livewire.dashboard.borrows.edit-borrow');
    }
}
