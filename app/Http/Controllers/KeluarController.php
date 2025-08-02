<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keluar;
use App\Models\Masuk;
use App\Models\Peminjaman;
use App\Models\User;
use App\Exports\KeluarExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class KeluarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barang = Barang::join('keluar', 'barang.id', '=', 'keluar.barang_id')
                ->join("status", "status.id", '=', 'barang.status_id')
                ->join('keadaan', 'keadaan.id', '=', 'barang.keadaan_id')
                ->join('lokasi', 'lokasi.id', '=', 'barang.lokasi_id')
                ->join('merk', 'merk.id', '=', 'barang.merk_id')
                ->join('kategori', 'kategori.id', '=', 'barang.kategori_id')
                ->leftJoin('masuk', 'masuk.barang_id', '=', 'barang.id')
                ->where('status.jenis', 'keluar')
                ->select([
                    'keluar.id',
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
                    // 'barang.keterangan as keterangan_barang',
                    'masuk.tanggal_masuk',
                    'keluar.tanggal_keluar',
                    'keluar.bukti_pengeluaran',
                    'keluar.keterangan as keterangan_keluar',
                    'keluar.created_at',
                    'keluar.updated_at'
                ]);
            return DataTables::of($barang)
            ->addIndexColumn()
                ->addColumn('bukti_pengeluaran', function ($row) {
                    $user = Auth::user();
                    $buttons = '';
                    
                    if ($row->bukti_pengeluaran) {
                        $downloadUrl = route('keluar.download-bukti', $row->id);
                        return '<a href="' . $downloadUrl . '" class="btn btn-success btn-sm" target="_blank">Download</a>';
                    } else {
                        return '<button class="btn btn-secondary btn-sm" disabled>Download</button>';
                    }
                })
                ->addColumn('aksi', function ($row) {
                $user = auth()->user();
                $buttons = [];

                // Tombol Upload
                if ($user->can('keluar.upload')) {
                $buttons[] = '<button class="btn btn-primary btn-upload-file"
                            data-barang-id="' . $row->barang_id . '"
                            data-keluar-id="' . $row->id . '"
                            style="width: 36px; height: 36px;">
                            <i class="bi bi-upload"></i>
                        </button>';
                }

                // Tombol Edit
                if ($user->can('keluar.update')) {
                    $editUrl = route('keluar.edit', $row->barang_id);
                    $buttons[] = '<a href="' . $editUrl . '" class="btn btn-warning"
                                style="width: 36px; height: 36px;">
                                <i class="bi bi-pencil"></i>
                            </a>';
                }

                // Tombol Delete File Bukti
                if ($user->can('keluar.upload') && $row->bukti_pengeluaran) {
                    $buttons[] = '<button class="btn btn-danger btn-delete-file"
                                data-keluar-id="' . $row->id . '"
                                style="width: 36px; height: 36px;">
                                <i class="bi bi-trash"></i>
                            </button>';
                }

                if (count($buttons)) {
                    return '<div class="d-flex align-items-center" style="gap: 8px;">' . implode('', $buttons) . '</div>';
                }

                return '-';
                })

                ->rawColumns(['aksi', 'bukti_pengeluaran'])
                ->toJson();
        }
        return view('keluar.index');
    }

    public function edit(Request $request, Barang $barang)
    {
        return view('keluar.edit', compact('barang'));
    }

    public function uploadBukti(Request $request, Keluar $keluar)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx|max:5120', // max 5MB
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');

        // Save $path or $filename to your DB if needed
        $keluar->bukti_pengeluaran = $path;
        $keluar->save();

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $path,
            'filename' => $filename,
        ]);
    }

    public function downloadBukti(Request $request, Keluar $keluar)
    {
        $filePath = $keluar->bukti_pengeluaran;
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found at ' . $filePath);
        }
        $fullPath = Storage::disk('public')->path($filePath);
        return response()->download($fullPath);
    }
    public function deleteBukti(Keluar $keluar)
    {
        if ($keluar->bukti_pengeluaran && Storage::disk('public')->exists($keluar->bukti_pengeluaran)) {
            Storage::disk('public')->delete($keluar->bukti_pengeluaran);
        }
        $keluar->bukti_pengeluaran = null;
        $keluar->save();

        return response()->json(['message' => 'File berhasil dihapus']);
    }
}
