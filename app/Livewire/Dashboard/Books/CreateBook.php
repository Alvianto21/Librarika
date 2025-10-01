<?php

namespace App\Livewire\Dashboard\Books;

use App\Livewire\Forms\BookForm;
use App\Models\Book;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

class CreateBook extends Component
{
    public BookForm $form;

    use WithFileUploads;

    /**
     * Submit form
     */
    public function save() {
        // Validate and create new book
        $this->form->store();

        session()->flash('BookCreateSuccess', 'Buku berhasil ditambahkan!');
        $this->redirect('/dashboard/books');
    }

    /**
     * Class constructor
     */
    public function mount() {
        $this->authorize('create', Book::class);
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Tambah Buku"])]

    public function render()
    {
        // Send slug example before user submit form
        if ($this->form->judul) {
            $slug = SlugService::createSlug(Book::class, 'slug', $this->form->judul);
            $this->form->slug = $slug;
        }
        return view('livewire.dashboard.books.create-book', ['slug' => $slug ?? '']);
    }
}
