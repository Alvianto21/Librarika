<?php

namespace App\Livewire\Dashboard\Borrows;

use App\Models\Borrow;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class UserBorrow extends Component
{
    use WithPagination;

    public $borrows;
    public $users;
    public $perPage = 10;

    public $search = '';
    public ?string $statusFilter = null;

    /**
     * Clear data search and filter on updating
     */
    public function updating($property) {
        if (in_array($property, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    /**
     * Class constructor
     */
    public function mount(Borrow $borrows, $search = '', $statusFilter = '') {
        // $this->users = $borrows->where('user_id', Auth::user()->id);
        $this->search = $search;
        $this->statusFilter = $statusFilter;
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Daftar Pinjam"])]
    
    public function render()
    {
        $this->users = Borrow::query()->where('user_id', Auth::user()->id);
        
        // Search
        if (!empty($this->search)) {
            $this->users->search($this->search);
        }

        // Filter
        if (!empty($this->statusFilter)) {
            $this->users->where('status_pinjam', $this->statusFilter);
        }

        // Get data
        $this->users->with(['book', 'user']);
        $this->users = $this->users->get();
        
        // Authorize
        foreach($this->users as $user) {
            $this->authorize("view", $user);
        }

        $borrowsSlice = collect($this->users);

        // Get page property
        $current = $this->getPage() ?? 1;

        // Slice data
        $this->borrows = $borrowsSlice->slice(($current - 1) * $this->perPage, $this->perPage)->values();

        // Create paginator
        $paginate = new LengthAwarePaginator(
            $this->borrows,
            $borrowsSlice->count(),
            $this->perPage,
            $current, [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        return view('livewire.dashboard.borrows.user-borrow', ['paginate' => $paginate]);
    }
}
