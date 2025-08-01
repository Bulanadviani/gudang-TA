<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Masuk;
use App\Models\Keluar;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Barang;


class HomeController extends Controller
{
    public function dashboard(): View
{
    $validBarangIds = Barang::whereNotNull('merk_id')
        ->whereNotNull('lokasi_id')
        ->whereNotNull('kategori_id')
        ->whereNotNull('keadaan_id')
        ->pluck('id');

    // Ambil barang_id yang sudah keluar atau dipinjam
    $barangKeluarIds = Keluar::pluck('barang_id')->toArray();
    $barangPeminjamanIds = Peminjaman::pluck('barang_id')->toArray();
    $barangSudahKeluarAtauDipinjam = array_merge($barangKeluarIds, $barangPeminjamanIds);

    // Hitung hanya barang masuk yang belum keluar/peminjaman
    $total_masuk = Masuk::whereIn('barang_id', $validBarangIds)
        ->whereNotIn('barang_id', $barangSudahKeluarAtauDipinjam)
        ->count();

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

    return view('dashboard', compact('barang_masuk', 'barang_keluar', 'barang_peminjaman'));
}

}
