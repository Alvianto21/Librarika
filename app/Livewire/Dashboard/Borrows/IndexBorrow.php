<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Models\Borrow;
use App\Notifications\BorrowAgreement;
use App\Notifications\RejectedBorrow;
use Illuminate\Support\Facades\Auth;
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

    public ?string $starting = null;
    public ?string $ending = null;

    /**
     * Reset page on updating search or filter
     */
    public function updateting($property) {
        if (in_array($property, ['search', 'statusFilter', 'starting', 'ending'])) {
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

            session()->flash('BorrowUpdateSuccess', 'Peminjaman telah disetujui');
            $borrow->user->notify(new BorrowAgreement($borrow));
            $this->resetPage();
        } else {
            session()->flash('BorrowUpdateFailed', 'Data pinjam tidak ada atau gagal diperbarui');
            $this->resetPage();
        }

    }

    /**
     * Rejected borrow
     */
    public function reject($code) {
        $this->authorize('update', Borrow::class);

        $borrow = Borrow::whereKodePinjam($code)->first();

        if ($borrow) {
            $borrow->status_pinjam = 'ditolak';
            $borrow->save();

            session()->flash('BorrowUpdateSuccess', 'Peminjaman telah ditolak');
            $borrow->user->notify(new RejectedBorrow($borrow));
            $this->resetPage();
        } else {
            session()->flash('BorrowUpdateFailed', 'Data pinjam tidak ada atau gagal diperbarui');
            $this->resetPage();
        }

    }

    /**
     * Export to Excel
     */
    public function exportExcel() {
        if (!Auth::user()->Role('admin')) {
            session()->flash('ActionDenied', 'Anda tidak memiliki izin untuk aksi ini');
            return;
        }

        $param = array_filter([
            'starting' => $this->starting,
            'ending' => $this->ending,
            'statusFilter' => $this->statusFilter
        ]);
        
        $this->redirectRoute('borrow.report.excel', $param);
    }
    
    /**
     * Export to PDF
    */
    public function exportPdf() {
        if (!Auth::user()->Role('admin')) {
            session()->flash('ActionDenied', 'Anda tidak memiliki izin untuk aksi ini');
            return;
        }
    
        $param = array_filter([
            'starting' => $this->starting,
            'ending' => $this->ending,
            'statusFilter' => $this->statusFilter
        ]);
        
        $this->redirectRoute('borrow.report.pdf', $param);
    }

    /**
     * Class constructor
     */
    public function mount($search = '', $statusFilter = '', $starting = null, $ending = null){
        $this->authorize("viewAny", Borrow::class);

        $this->search = $search;
        $this->statusFilter = $statusFilter;
        $this->starting = $starting;
        $this->ending = $ending;
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

        if (!empty($this->starting) || !empty($this->ending)) {
            $query->whereBetween('tgl_pinjam', [$this->starting, $this->ending]);
        }

        $query->with(['book', 'user']);
        
        return view('livewire.dashboard.borrows.index-borrow', ['borrows' => $query->orderBy($this->colname, $this->sortdir)->paginate(10)->withQueryString()]);
    }
}
