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

    /**
     * Scipe a query to search borrows
     */
    public function mount(Borrow $borrows) {
        $this->users = $borrows->where('user_id', Auth::user()->id)->get();

        foreach($this->users as $user) {
            $this->authorize("view", $user);
        }

    }

    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Info Pinjam"])]

    public function render()
    {
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
