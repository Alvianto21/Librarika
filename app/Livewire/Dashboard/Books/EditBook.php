<?php

namespace App\Livewire\Dashboard\Books;

use App\Livewire\Forms\BookUpdateForm;
use App\Models\Book;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditBook extends Component
{
    public BookUpdateForm $form;

    use WithFileUploads;

    public $book;

    /**
     * Submit form
     */
    public function save() {
        // Validate and update book
        $this->form->update();

        session()->flash('BookUpdateSuccess', 'Buku berhasil diperbarui!');
        $this->redirect('/dashboard/books');
    }

    /**
     * Class constructor
     */
    public function mount(Book $book) {
        $this->authorize('update', $book);
        $this->form->setBook($book);
    }

    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Edit Buku"])]
    
    public function render()
    {
        // Send slug example only user edit the judul
        if ($this->form->judul != $this->book->judul) {
            $slug = SlugService::createSlug(Book::class, 'slug', $this->form->judul);
            $this->form->slug = $slug;
        }

        return view('livewire.dashboard.books.edit-book', ['slug' => $slug ?? '']);
    }
}
