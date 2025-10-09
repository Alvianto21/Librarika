<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Models\Book;
use App\Models\Borrow;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\UserBorrowForm;

class UserBorrowCreate extends Component
{
    public UserBorrowForm $form;

    public $books;
    /**
     * Class constructor
     */
    public function mount(Book $books) {
        // Authorize
        $this->authorize('create', Borrow::class);

        // Cek Jika user udah pinjam buku
        if (Auth::user()->borrows()->where('status_pinjam', 'dipinjam')->exists()) {
            session()->flash('UserBorrowCreateError', 'Anda masih memiliki buku yang belum dikembalikan. Silahkan kembalikan buku tersebut terlebih dahulu');
            $this->redirectRoute('users.borrows');
        }

        $this->books = Book::select('judul', 'id')->get();
    }

    /**
     * Submit form
     */
    public function save() {
        $this->form->user_id = Auth::user()->id;
        // Validate and create new borrow
        $this->form->store();

        session()->flash('UserBorrowCreateSuccess', 'Berhasil mengajukan peminjaman buku. Silahkan tunggu konfirmasi dari petugas');
        $this->redirectRoute('users.borrows');
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Pinjam Buku"])]
    
    public function render()
    {
        // Set bew kode pinjam
        $this->form->kode_pinjam = 'TXBOR-' . Str::uuid()->toString();
        $kode = $this->form->kode_pinjam;
        
        return view('livewire.dashboard.borrows.user-borrow-create', ['code' => $kode]);
    }
}
