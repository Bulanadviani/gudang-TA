<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Masuk;
use App\Models\Keluar;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Status;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Exports\MasukExport;
use App\Imports\BarangMasukImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class MasukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()){
        $barang = Barang::join('masuk', 'barang.id', '=', 'masuk.barang_id')
            ->join("status","status.id",'=','barang.status_id')
            ->join('keadaan', 'keadaan.id', '=', 'barang.keadaan_id')
            ->join('lokasi', 'lokasi.id', '=', 'barang.lokasi_id')
            ->join('merk', 'merk.id', '=', 'barang.merk_id')
            ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
            ->where('status.jenis', 'masuk') 
            ->select([
                'masuk.id',          
                'barang.id as barang_id',
                'barang.kode_rak',
                'barang.serial_number',
                'barang.kode_material',
                'merk.nama as merk',
                'barang.spesifikasi',
                'kategori.nama as kategori',
                'keadaan.nama as keadaan',
                'lokasi.nama as lokasi',
                'status.nama as status',
                'barang.keterangan',
                'masuk.tanggal_masuk',
                'masuk.created_at',
                'masuk.updated_at'
            ]);
            return DataTables::of($barang)->toJson();
        } 
        return view('masuk.index');
    }

    public function create(){
        return view('masuk.create');
    }

        public function importFromExcel(Request $request)
    {
        try {
            $file = $request->file('file');
            $namaFile = $file->getClientOriginalName();
            $file->move('DataMasuk', $namaFile);

            Excel::import(new BarangMasukImport, public_path('/DataMasuk/' . $namaFile));
            return redirect('masuk')->with('success', 'Import Data Barang Berhasil');
        } catch (\Throwable $th) {
            return redirect('masuk')->with('error', 'Import Data Barang Gagal');
        }

    }

    public function edit(Request $request,Barang $barang)
    {
        return view('masuk.edit', compact('barang'));
    }

    public function multiEdit(Request $request)
{
    $ids = explode(',', $request->barang_ids);
    $tujuan = $request->tujuan;

    if ($tujuan === 'keluar') {
        $request->validate([
            'tanggal_keluar' => 'required|date',
        ]);

        $statusKeluar = Status::where('nama', 'Barang Keluar')->first();
        if (!$statusKeluar) {
            return redirect()->back()->with('error', 'Status "Barang Keluar" tidak ditemukan di database.');
        }

        foreach ($ids as $id) {
            Keluar::create([
                'barang_id' => $id,
                'tanggal_keluar' => $request->tanggal_keluar,
                'created_by' => Auth::id(),
            ]);

            Barang::where('id', $id)->update(['status_id' => $statusKeluar->id]);
        }

    } elseif ($tujuan === 'peminjaman') {
        $request->validate([
            'tanggal_bastp' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_bastp',
            'nomor_surat' => 'required|string|max:255',
        ]);

        $statusPinjam = Status::where('nama', 'Peminjaman')->first();
        if (!$statusPinjam) {
            return redirect()->back()->with('error', 'Status "Peminjaman" tidak ditemukan di database.');
        }

        foreach ($ids as $id) {
            Peminjaman::create([
    'barang_id' => $id,
    'tanggal_bastp' => $request->tanggal_bastp,
    'tanggal_selesai' => $request->tanggal_selesai,
    'nomor_surat' => $request->nomor_surat,
    'created_by' => Auth::id(),
    'pic' => Auth::id(),
]);

            Barang::where('id', $id)->update(['status_id' => $statusPinjam->id]);
        }
    }

    return redirect()->route('masuk.index')->with('success', 'Barang berhasil dipindahkan!');
}


}
