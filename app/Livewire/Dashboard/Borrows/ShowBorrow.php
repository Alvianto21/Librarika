<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Models\Borrow;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ShowBorrow extends Component
{
    public $borrow;

    public $tgl_pinjam;
    public $tgl_kembali;

    /**
     * Class constructor
     */
    public function mount(Borrow $borrow) {
        $this->authorize('view', Borrow::class);
        $this->borrow = $borrow;

        $this->tgl_pinjam = $borrow->formattdDate($borrow->tgl_pinjam);
        $this->tgl_kembali = $borrow->formattdDate($borrow->tgl_kembali);
        $this->fill($borrow->only([
            'status_buku',
            'nama',
            'username',
            'judul',
            'ISBN'
        ]));
    }

    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Info Pinjam"])]

    public function render()
    {
        return view('livewire.dashboard.borrows.show-borrow');
    }
}
