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

    public function save() {
        $this->form->store();

        session()->flash('BookCreateSuccess', 'Buku berhasil ditambahkan!');
        $this->redirect('/dashboard/books');
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Tambah Buku"])]

    public function render()
    {
        if ($this->form->judul) {
            $slug = SlugService::createSlug(Book::class, 'slug', $this->form->judul);
            $this->form->slug = $slug;
        }
        return view('livewire.dashboard.books.create-book', ['slug' => $slug ?? '']);
    }
}
