<?php

namespace App\Http\Controllers;

use App\Exports\BorrowsExport;
use App\Models\Borrow;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class ReportExportController extends Controller
{
    /**
     * Export to Excel
     */
    public function exportExcel(Request $request) {
        Gate::authorize('viewAny', Borrow::class);

        $statusFilter = $request->query('statusFilter');
        $starting = $request->query('starting');
        $ending = $request->query('ending');
        $filename = 'borrow-report' . now()->format('Ymd_His') . '.xlsx';
        
        return Excel::download(new BorrowsExport($statusFilter, $starting, $ending), 
        $filename, ExcelExcel::XLSX);
    }
    
    /**
     * Export PDF
    */
    public function exportPDF(Request $request) {
        Gate::authorize('viewAny', Borrow::class);
        
        $statusFilter = $request->query('statusFilter');
        $starting = $request->query('starting');
        $ending = $request->query('ending');
        $filename = 'borrow-report' . now()->format('Ymd_His') . '.pdf';

        $query = Borrow::query()->with('book', 'user')
                        ->when($starting || $ending, fn($limit) => 
                        $limit->whereBetween('tgl_pinjam', [$starting, $ending]))
                        ->when($statusFilter, fn($filter) => 
                        $filter->where('status_pinjam', $statusFilter))
                        ->latest();
        
        $borrows = $query->get();

        $pdf = Pdf::loadView('dashboard.report-borrows', [
            'borrows' => $borrows,
            'starting' => $starting,
            'ending' => $ending
        ]);
        return $pdf->download($filename);
    }
}
