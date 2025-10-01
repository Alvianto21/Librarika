<?php

namespace App\Livewire\Dashboard\Books;

use App\Models\Book;
use Livewire\Component;
use Livewire\Attributes\Layout;

class ShowBook extends Component
{
    public $book;

    /**
     * Class constructor
     */
    public function mount(Book $book) {
        $this->authorize('view', Book::class);
        $this->book = $book;
        $this->fill($book->only([
            'judul',
            'ISBN',
            'penulis',
            'penerbit',
            'tahun_terbit',
            'deskripsi',
            'jml_pinjam',
            'foto_sampul'
        ]));
    }

    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Info Buku"])]
    
    public function render()
    {
        return view('livewire.dashboard.books.show-book');
    }
}
