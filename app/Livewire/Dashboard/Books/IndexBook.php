<?php

namespace App\Livewire\Dashboard\Books;

use App\Models\Book;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class IndexBook extends Component
{
    use WithPagination;

    public $search = '';

    // reset search
    public function search() {
        $this->resetPage();
    }

    public function mount($search = '') {
        $this->authorize("viewAny", Book::class);
        $this->search = $search;
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Daftar Buku"])]

    public function render()
    {
        $query = Book::query();

        if (!empty($this->search)) {
            $query->search($this->search);
        }
        return view('livewire.dashboard.books.index-book', [
            'books' => $query->paginate(10)
        ]);
    }
}
