<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Menampilkan semua buku
     */
    public function index(Request $request) {
        // Cek otorisasi user
        if ($request->user()->cannot('viewAny', Book::class)) {
            abort(403, 'Anda tidak memiliki ijin untuk aksi ini.');
        }
        
        $books = Book::paginate(10);
        return view('dashboard.book.index', [
            'title' => 'Daftar Buku',
            'books' => $books
        ]);
    }
}
