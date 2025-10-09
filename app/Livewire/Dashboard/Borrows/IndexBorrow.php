<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Models\Borrow;
use App\Notifications\BorrowAgreement;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class IndexBorrow extends Component
{
    use WithPagination;

    public $search = '';

    public ?string $statusFilter = null;

    public $colname = 'id';
    public $sortdir = 'asc';

    /**
     * Reset page on updating search or filter
     */
    public function updateting($property) {
        if (in_array($property, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    /**
     * Sort by colomn
     */
    public function sortTable($colmn) {
        $this->colname = $colmn;
        $this->sortdir = $this->sortdir == 'asc' ? 'desc' : 'asc';
    }

    /**
     * Approve borrow
     */
    public function approve($code) {
        $this->authorize('update', Borrow::class);

        $borrow = Borrow::whereKodePinjam($code)->first();

        if ($borrow) {
            $borrow->status_pinjam = 'dipinjam';
            $borrow->book->increment('jml_pinjam', 1);
            $borrow->save();

            session()->flash('BorrowUpdateSuccess', 'Peminjaman telah disetuhui');
            $borrow->user->notify(new BorrowAgreement($borrow));
        } else {
            session()->flash('BorrowUpdateFailed', 'Data pinjam tidak ada atau gagal diperbarui');
            return;
        }
    }

    /**
     * Class constructor
     */
    public function mount($search = '', $statusFilter = ''){
        $this->authorize("viewAny", Borrow::class);

        $this->search = $search;
        $this->statusFilter = $statusFilter;
    }

    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Daftar Pinjam"])]
    
    public function render()
    {
        $query = Borrow::query();

        if (!empty($this->search)) {
            $query->search($this->search);
        }

        if (!empty($this->statusFilter)) {
            $query->where('status_pinjam', $this->statusFilter);
        }

        $query->with(['book', 'user']);
        
        return view('livewire.dashboard.borrows.index-borrow', ['borrows' => $query->orderBy($this->colname, $this->sortdir)->paginate(10)->withQueryString()]);
    }
}
