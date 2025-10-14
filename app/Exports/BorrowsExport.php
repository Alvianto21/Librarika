<?php

namespace App\Exports;

use App\Models\Borrow;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * Query Parameter
     */
    public function __construct(protected $statusFilter = null, protected $starting = null, protected $ending = null) {
        $this->statusFilter = $statusFilter;
        $this->starting = $starting;
        $this->ending = $ending;
    }

    /**
     * Export tablw from query
     */
    public function query() {
        return Borrow::query()->with('book', 'user')
                        ->when($this->starting || $this->ending, fn($limit) => 
                        $limit->whereBetween('tgl_pinjam', [$this->starting, $this->ending]))
                        ->when($this->statusFilter, fn($filter) => 
                        $filter->where('status_pinjam', $this->statusFilter))
                        ->select('borrows.*');
    }

    /**
     * Mapping data
     * @param Borrow $borrow
     */
    public function map($borrow): array
    {
        return [
            $borrow->kode_pinjam,
            $borrow->user->nama,
            $borrow->book->judul,
            $borrow->status_pinjam,
            Carbon::parse($borrow->tgl_pinjam)->format('d-m-Y'),
            Carbon::parse($borrow->tgl_kembali)->format('d-m-Y') 
        ];
    }

    /**
     * Colmn headers
     */
    public function headings(): array {
        return [
            'Kode Pinjam',
            'Nama Pengguna',
            'Judul Buku',
            'Status Pinjam',
            'Tanggal Pinjam',
            'Tanggal Kembali'
        ];
    }
}
