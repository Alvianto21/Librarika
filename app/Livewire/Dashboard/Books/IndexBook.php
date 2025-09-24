<?php

namespace App\Livewire\Dashboard\Books;

use App\Models\Book;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class IndexBook extends Component
{
    use WithPagination;

    public function mount() {
        $this->authorize("viewAny", Book::class);
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Daftar Buku"])]

    public function render()
    {
        $books = Book::latest()->paginate(10);
        return view('livewire.dashboard.books.index-book', [
            'books' => $books
        ]);
    }
}
