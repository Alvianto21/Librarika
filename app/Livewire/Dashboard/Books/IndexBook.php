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
    public ?string $conditionFilter = null;
    public $colname = 'id';
    public $sortdir = 'asc';

    /**
     * Reset search
     */
    public function search() {
        $this->resetPage();
    }

    /**
     * Reset page on updating search or filter
     */
    public function updating($property, $value) {
        if(in_array($property, ['search', 'conditionFilter'])) {
            $this->resetPage();
        }
    }

    /**
     * Sort by colum
     */
    public function sortTable($colname) {
        $this->colname === $colname;
        $this->sortdir = $this->sortdir == 'asc' ? 'desc' : 'asc';
    }

    /**
     * Class constructor
     */
    public function mount($search = '', string $conditionFilter = '') {
        // Aothorize user
        $this->authorize("viewAny", Book::class);
        
        $this->search = $search;
        $this->conditionFilter = $conditionFilter;
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Daftar Buku"])]

    public function render()
    {
        $query = Book::query();

        if (!empty($this->search)) {
            $query->search($this->search);
        }

        if(!empty($this->conditionFilter)) {
            $query->where('kondisi', $this->conditionFilter);
        }

        return view('livewire.dashboard.books.index-book', [
            'books' => $query->orderBy($this->colname, $this->sortdir)->paginate(10)->withQueryString(),
        ]);
    }
}
