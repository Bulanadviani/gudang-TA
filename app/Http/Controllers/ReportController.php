<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Masuk;
use App\Models\Keluar;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Exports\MasukExport;
use App\Exports\KeluarExport;
use App\Exports\PeminjamanExport;
use PDF;

use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(): View {
    // Ambil semua barang_id yang valid
    $validBarangIds = \App\Models\Barang::whereNotNull('merk_id')
        ->whereNotNull('lokasi_id')
        ->whereNotNull('kategori_id')
        ->whereNotNull('keadaan_id')
        ->pluck('id');

    // Ambil ID barang yang sudah keluar atau dipinjam
    $barangKeluarIds = Keluar::pluck('barang_id')->toArray();
    $barangPeminjamanIds = Peminjaman::pluck('barang_id')->toArray();
    $barangSudahKeluarAtauDipinjam = array_merge($barangKeluarIds, $barangPeminjamanIds);

    // Hitung hanya barang masuk yang belum berpindah
    $total_masuk = Masuk::whereIn('barang_id', $validBarangIds)
        ->whereNotIn('barang_id', $barangSudahKeluarAtauDipinjam)
        ->count();

    // Hitung barang keluar dan peminjaman seperti biasa
    $total_keluar = Keluar::whereIn('barang_id', $validBarangIds)->count();
    $total_peminjaman = Peminjaman::whereIn('barang_id', $validBarangIds)->count();

    $total_semua = $total_masuk + $total_keluar + $total_peminjaman;

    $barang_masuk = [
        "total" => $total_masuk,
        "percentage" => $total_semua > 0 ? round(($total_masuk / $total_semua) * 100, 2) : 0
    ];

    $barang_keluar = [
        "total" => $total_keluar,
        "percentage" => $total_semua > 0 ? round(($total_keluar / $total_semua) * 100, 2) : 0
    ];

    $barang_peminjaman = [
        "total" => $total_peminjaman,
        "percentage" => $total_semua > 0 ? round(($total_peminjaman / $total_semua) * 100, 2) : 0
    ];

    return view('report.index', compact('barang_masuk', 'barang_keluar', 'barang_peminjaman'));
}


    public function downloadReportMasuk(Request $request, string $type)
{
    $validBarangIds = Barang::whereNotNull('merk_id')
        ->whereNotNull('lokasi_id')
        ->whereNotNull('kategori_id')
        ->whereNotNull('keadaan_id')
        ->pluck('id');

    $barangKeluarIds = Keluar::pluck('barang_id')->toArray();
    $barangPeminjamanIds = Peminjaman::pluck('barang_id')->toArray();
    $barangSudahKeluarAtauDipinjam = array_merge($barangKeluarIds, $barangPeminjamanIds);

    $masukData = Masuk::with(['barang.merk', 'barang.kategori', 'barang.keadaan', 'barang.lokasi', 'barang.status'])
        ->whereIn('barang_id', $validBarangIds)
        ->whereNotIn('barang_id', $barangSudahKeluarAtauDipinjam)
        ->get();

    if ($type === "pdf") {
        $pdf = Pdf::loadView('report.template.barang-masuk', compact('masukData'))
              ->setPaper('a2', 'landscape');
        return $pdf->download('laporan-barang-masuk.pdf');
    }

    return Excel::download(new MasukExport($masukData), 'laporan-barang-masuk.xlsx');
}

    
public function downloadReportKeluar(Request $request, string $type)
{
    // Instantiate the KeluarExport class
    $export = new KeluarExport();

    // Get the collection of data directly from the export class's collection() method
    $keluarData = $export->collection();

    $keluarData = Keluar::with('barang')
        // ->when($request->filled('tanggal_awal') && $request->filled('tanggal_akhir'), function ($query) use ($request) {
        //     $query->whereBetween('tanggal_keluar', [$request->tanggal_awal, $request->tanggal_akhir]);
        // })
        // ->orderBy('tanggal_keluar', 'asc')
        ->get();

    // $pdf = Pdf::loadView('laporan.keluar_pdf', compact('keluarData'))
    //     ->setPaper('a4', 'landscape');

    // return $pdf->download('laporan-barang-keluar.pdf');

    if ($type === "pdf") {
        // Pass the obtained data to your PDF view
        $pdf = Pdf::loadView('report.template.barang-keluar', compact('keluarData'))
                    ->setPaper('a2', 'landscape');
        return $pdf->download('laporan-barang-keluar.pdf');
    }

    // For Excel, you can simply pass the export instance
    return Excel::download($export, 'laporan-barang-keluar.xlsx');
}


public function downloadReportPeminjaman(Request $request, string $type)
{
    // Buat instance dari export class
    $export = new PeminjamanExport();

    // Ambil data menggunakan collection() dari export class
    $peminjamanData = $export->collection();

    if ($type === 'pdf') {
        $pdf = PDF::loadView('report.template.barang-peminjaman', compact('peminjamanData'))
                  ->setPaper('a2', 'landscape');
        return $pdf->download('laporan-barang-peminjaman.pdf');
    }

    return Excel::download($export, 'laporan-barang-peminjaman.xlsx');
}


}
