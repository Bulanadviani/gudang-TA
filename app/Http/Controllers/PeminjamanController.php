<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Masuk;
use App\Models\Keluar;
use App\Models\User;
use App\Models\Status;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $driver = DB::getDriverName();
            $sisa_waktu = DB::getDriverName() === 'pgsql'
                ? DB::raw("(peminjaman.tanggal_selesai - NOW()::date) AS sisa_waktu")
                : DB::raw("DATEDIFF( peminjaman.tanggal_selesai,NOW()) AS sisa_waktu");

            $barang = Barang::join('peminjaman', 'barang.id', '=', 'peminjaman.barang_id')
                ->join('status', 'status.id', '=', 'barang.status_id')
                ->join('merk', 'merk.id', '=', 'barang.merk_id')
                ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
                ->join('users', 'users.id', '=', 'peminjaman.pic')
                ->select([
                    'peminjaman.nomor_surat',
                    'barang.serial_number',
                    'barang.kode_material',
                    'merk.nama as merk',
                    'barang.spesifikasi',
                    'kategori.nama as kategori',
                    'peminjaman.tanggal_bastp',
                    'peminjaman.tanggal_selesai',
                    'users.name as pic',
                    'barang.keterangan',
                    $sisa_waktu,
                    'barang.id as barang_id',
                ]);

            return DataTables::of($barang)->toJson();
        }

        // Hitung peminjaman yang akan jatuh tempo dalam 7 hari
        $notif_7_hari = Peminjaman::whereDate('tanggal_selesai', '<=', now()->addDays(7))
            ->whereDate('tanggal_selesai', '>=', now())
            ->count();

        // Hitung peminjaman yang sudah melewati batas waktu (overdue)
        $notif_terlambat = Peminjaman::whereDate('tanggal_selesai', '<', now())->count();

        return view('peminjaman.index', compact('notif_7_hari', 'notif_terlambat'));
    }

    public function edit(Request $request, Barang $barang)
    {
        return view('peminjaman.edit', compact('barang'));
    }

    public function multiEdit(Request $request)
{
    $ids = explode(',', $request->barang_ids);
    $tujuan = $request->tujuan;

    if ($tujuan === 'masuk') {
        $request->validate([
            'tanggal_masuk' => 'required|date',
        ]);

        $statusMasuk = Status::where('nama', 'Barang Masuk')->first();

if (!$statusMasuk) {
    return redirect()->back()->with('error', 'Status "Barang Masuk" tidak ditemukan di database.');
}

// ini aman karena statusMasuk sudah dipastikan tidak null
foreach ($ids as $id) {
    $sudahMasuk = Masuk::where('barang_id', $id)->exists();

    if (!$sudahMasuk) {
        Masuk::create([
            'barang_id' => $id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'created_by' => Auth::id(),
        ]);
    }

    Barang::where('id', $id)->update(['status_id' => $statusMasuk->id,]);

    Peminjaman::where('barang_id', $id)->delete();
}


    } elseif ($tujuan === 'keluar') {
    $request->validate([
        'tanggal_keluar' => 'required|date',
        'berita_acara' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    $filePath = null;
    if ($request->hasFile('berita_acara')) {
        $filePath = $request->file('berita_acara')->store('berita_acara_keluar', 'public');
    }

    $statusKeluar = Status::where('nama', 'Barang Keluar')->first();
    if (!$statusKeluar) {
        return redirect()->back()->with('error', 'Status "Keluar" tidak ditemukan di database.');
    }

    foreach ($ids as $id) {
        Keluar::create([
            'barang_id' => $id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'bukti_pengeluaran' => $filePath,
            'keterangan' => $request->keterangan_keluar,
            'created_by' => Auth::id(),
        ]);

        Barang::where('id', $id)->update(['status_id' => $statusKeluar->id]);

        // Hapus dari tabel peminjaman
        Peminjaman::where('barang_id', $id)->delete();
    }
}


    return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dipindahkan!');
}

}
