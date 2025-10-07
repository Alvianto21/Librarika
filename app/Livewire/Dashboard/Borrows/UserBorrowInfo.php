<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Models\Borrow;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class UserBorrowInfo extends Component
{
    public $users;
    public $borrow;

    public $tgl_pinjam;
    public $tgl_kembali;
   
    /**
     * Scipe a query to search borrows
     */
    public function mount(Borrow $borrow) {
        $this->users = $borrow->where('user_id', Auth::user()->id)->get();

        foreach($this->users as $user) {
            $this->authorize("view", $user);
        }

        $this->borrow = $borrow;
        $this->tgl_pinjam = $borrow->formattdDate($borrow->tgl_pinjam);
        $this->tgl_kembali = $borrow->formattdDate($borrow->tgl_kembali);
        $this->fill($borrow->only([
            'nama',
            'username',
            'judul',
            'ISBN',
            'foto_sampul',
            'status_pinjam',
            'tgl_pinjam',
            'tgl_kembali',
            'kode_pinjam'
        ]));
    }

    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Info Pinjam"])]
    
    public function render()
    {
        return view('livewire.dashboard.borrows.user-borrow-info');
    }
}
