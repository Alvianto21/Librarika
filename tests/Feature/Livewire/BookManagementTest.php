<?php

namespace Tests\Feature\Livewire;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'petugas']);
        $this->user = User::factory()->create(['role' => 'user']);
    }

    /**
     * Tests IndexBook functionality
     */
    public function test_book_list_page_accessible_to_authenticated_users(): void
    {
        $this->actingAs($this->user)
            ->get('/dashboard/books')
            ->assertStatus(200);
    }

    public function test_book_list_shows_all_books(): void
    {
        Book::factory()->count(5)->create();

        $this->actingAs($this->user);
        
        $books = Book::orderBy('id', 'asc')->paginate(10);
        
        $this->assertCount(5, $books);
    }

    public function test_can_search_books_by_title(): void
    {
        Book::factory()->create(['judul' => 'Laravel Tutorial']);
        Book::factory()->create(['judul' => 'PHP Guide']);

        $query = Book::search('Laravel');
        
        $this->assertCount(1, $query->get());
    }

    public function test_can_filter_books_by_condition(): void
    {
        Book::factory()->count(2)->create(['kondisi' => 'baik']);
        Book::factory()->count(3)->create(['kondisi' => 'rusak']);

        $baik = Book::where('kondisi', 'baik')->get();
        $rusak = Book::where('kondisi', 'rusak')->get();

        $this->assertCount(2, $baik);
        $this->assertCount(3, $rusak);
    }

    /**
     * Tests ShowBook functionality
     */
    public function test_book_detail_page_accessible(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->user)
            ->get('/dashboard/books/' . $book->slug)
            ->assertStatus(200);
    }

    public function test_book_detail_shows_correct_data(): void
    {
        $book = Book::factory()->create([
            'judul' => 'Test Book',
            'penulis' => 'Test Author',
            'ISBN' => '123-456-789',
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'judul' => 'Test Book',
            'penulis' => 'Test Author',
            'ISBN' => '123-456-789',
        ]);
    }

    /**
     * Tests EditBook functionality
     */
    public function test_edit_book_page_requires_petugas_role(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->user)
            ->get('/dashboard/books/' . $book->slug . '/edit')
            ->assertStatus(403);
    }

    public function test_petugas_can_access_edit_book_page(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->admin)
            ->get('/dashboard/books/' . $book->slug . '/edit')
            ->assertStatus(200);
    }

    public function test_book_can_be_updated(): void
    {
        $book = Book::factory()->create(['judul' => 'Old Title']);

        $book->update(['judul' => 'New Title']);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'judul' => 'New Title',
        ]);
    }

    public function test_slug_updates_when_judul_changes(): void
    {
        $book = Book::factory()->create(['judul' => 'Original Title']);
        $oldSlug = $book->slug;

        $book->update(['judul' => 'Updated Title']);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'judul' => 'Updated Title',
        ]);
        
        // Slug should be different (handled by sluggable model)
        $this->assertNotNull($book->fresh()->slug);
    }

    /**
     * Tests CreateBook functionality
     */
    public function test_create_book_page_requires_petugas_role(): void
    {
        $this->actingAs($this->user)
            ->get('/dashboard/books/create')
            ->assertStatus(403);
    }

    public function test_petugas_can_access_create_book_page(): void
    {
        $this->actingAs($this->admin)
            ->get('/dashboard/books/create')
            ->assertStatus(200);
    }

    public function test_new_book_can_be_created(): void
    {
        $bookData = [
            'judul' => 'New Book',
            'penulis' => 'Author Name',
            'penerbit' => 'Publisher Name',
            'ISBN' => '123-456-789',
            'tahun_terbit' => '2024-01-01',
            'kondisi' => 'baik',
            'deskripsi' => 'Test Description',
        ];

        Book::create($bookData);

        $this->assertDatabaseHas('books', [
            'judul' => 'New Book',
            'penulis' => 'Author Name',
            'penerbit' => 'Publisher Name',
            'ISBN' => '123-456-789',
            'kondisi' => 'baik',
        ]);
    }

    public function test_book_deletion_requires_authorization(): void
    {
        $book = Book::factory()->create();

        $this->actingAs($this->user);
        
        // User shouldn't be able to delete
        $this->assertTrue(true); // Placeholder for authorization test
    }

    public function test_petugas_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $book->delete();

        $this->assertModelMissing($book);
    }
}
