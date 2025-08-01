<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Masuk;
use App\Models\Keluar;
use App\Models\Peminjaman;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException; // Import ValidationException
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::paginate(10); // Or whatever pagination you prefer
        return view('barang', compact('barang'));
    }

public function store(Request $request)
{

    $validatedData = $request->validate([
        'kode_rak'            => 'required|string',
        'serial_number' => 'required|string|unique:barang,serial_number',
        'kode_material'       => 'required|string',
        'merk'                => 'required|integer|exists:merk,id',
        'spesifikasi'         => 'required|string',
        'kategori'            => 'required|integer|exists:kategori,id',
        'keadaan'             => 'required|integer|exists:keadaan,id',
        'lokasi'              => 'required|integer|exists:lokasi,id',
        'status'              => 'required|integer|exists:status,id',
        'keterangan'          => 'nullable|string',

        // Status tambahan
        'tanggal_masuk'   => 'nullable|date',
        'tanggal_keluar'  => 'nullable|date',
        'tanggal_bastp'   => 'nullable|date',
        'tanggal_selesai' => 'nullable|date',
        'nomor_surat'=> 'nullable|string',
    ]);

    $status = Status::find($validatedData['status']);

    if (!$status) {
        return back()->withErrors(['status' => 'Status tidak ditemukan.']);
    }

    // Validasi tambahan berdasarkan jenis status
    if ($status->jenis === 'masuk' && empty($request->tanggal_masuk)) {
        return back()->withErrors(['tanggal_masuk' => 'Tanggal masuk wajib diisi untuk status masuk.']);
    }

    if ($status->jenis === 'keluar' && empty($request->tanggal_keluar)) {
        return back()->withErrors(['tanggal_keluar' => 'Tanggal keluar wajib diisi untuk status keluar.']);
    }

    if ($status->jenis === 'peminjaman') {
        if (empty($request->tanggal_bastp)) {
            return back()->withErrors(['tanggal_bastp' => 'Tanggal BASTP wajib diisi untuk status peminjam.']);
        }
        if (empty($request->tanggal_selesai)) {
            return back()->withErrors(['tanggal_selesai' => 'Tanggal selesai wajib diisi untuk status peminjam.']);
        }
    }


    DB::beginTransaction();
    try {
        $barang = Barang::create([
            'kode_rak'      => $validatedData['kode_rak'],
            'serial_number' => $validatedData['serial_number'],
            'kode_material' => $validatedData['kode_material'],
            'merk_id'          => $validatedData['merk'],
            'spesifikasi'   => $validatedData['spesifikasi'],
            'kategori_id'      => $validatedData['kategori'],
            'keadaan_id'       => $validatedData['keadaan'],
            'lokasi_id'        => $validatedData['lokasi'],
            'status_id'        => $validatedData['status'],
            'keterangan'    => $validatedData['keterangan'],
        ]);

        if ($status->jenis == "masuk") { // masuk
            Masuk::create([
                'barang_id'     => $barang->id,
                'tanggal_masuk' => $validatedData['tanggal_masuk'],
            ]);
            DB::commit();
            return to_route('masuk.index');
        }

        if ($status->jenis == "keluar") { // keluar
            Keluar::create([
                'barang_id'      => $barang->id,
                'tanggal_keluar' => $validatedData['tanggal_keluar'],
            ]);
            DB::commit();
            return to_route('keluar.index')->with('success', 'Barang masuk berhasil ditambahkan');
        }

        if ($status->jenis == "peminjaman") { // pinjam
            Peminjaman::create([
                'barang_id'       => $barang->id,
                'nomor_surat'     => $validatedData['nomor_surat'],
                'tanggal_bastp'   => $validatedData['tanggal_bastp'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'pic'             => Auth::user()->id,
            ]);
            DB::commit();
            return to_route('peminjaman.index')->with('success', 'Peminjaan barang berhasil ditambahkan');
        }

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors("error","Gagal menambahkan barang");
    }
}


    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'kode_rak'            => 'required|string',
            'serial_number' => 'required|string|unique:barang,serial_number,' . $id,
            'kode_material'       => 'required|string',
            'merk'                => 'required|integer|exists:merk,id',
            'spesifikasi'         => 'required|string',
            'kategori'            => 'required|integer|exists:kategori,id',
            'keadaan'             => 'required|integer|exists:keadaan,id',
            'lokasi'              => 'required|integer|exists:lokasi,id',
            'status'              => 'required|integer|exists:status,id',
            'keterangan'          => 'nullable|string',
            'nomor_surat'          => 'nullable|string',
            'tanggal_masuk'   => 'nullable|date',
            'tanggal_keluar'  => 'nullable|date',
            'tanggal_bastp'   => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $status = Status::find($validatedData['status']);

        if (!$status) {
            return back()->withErrors(['status' => 'Status tidak ditemukan.']);
        }

        // Validasi tambahan berdasarkan jenis status
        if ($status->jenis === 'masuk' && empty($request->tanggal_masuk)) {
            return back()->withErrors(['tanggal_masuk' => 'Tanggal masuk wajib diisi untuk status masuk.']);
        }

        if ($status->jenis === 'keluar' && empty($request->tanggal_keluar)) {
     
            return back()->withErrors(['tanggal_keluar' => 'Tanggal keluar wajib diisi untuk status keluar.']);
        }

        if ($status->jenis === 'peminjaman') {
            if (empty($request->tanggal_bastp)) {
                return back()->withErrors(['tanggal_bastp' => 'Tanggal BASTP wajib diisi untuk status pinjam.']);
            }
            if (empty($request->tanggal_selesai)) {
                return back()->withErrors(['tanggal_selesai' => 'Tanggal selesai wajib diisi untuk status pinjam.']);
            }
        }


        DB::beginTransaction();

        try {
            $barang = Barang::findOrFail($id);
            

            // Simpan update barang
            $barang->update([
                'kode_rak'       => $validatedData['kode_rak'],
                'serial_number'  => $validatedData['serial_number'],
                'kode_material'  => $validatedData['kode_material'],
                'merk_id'           => $validatedData['merk'],
                'spesifikasi'    => $validatedData['spesifikasi'],
                'kategori_id'       => $validatedData['kategori'],
                'keadaan_id'        => $validatedData['keadaan'],
                'lokasi_id'         => $validatedData['lokasi'],
                'status_id'         => $validatedData['status'],
                'keterangan'     => $validatedData['keterangan'],
            ]);

            // Hapus entri status sebelumnya
            Masuk::where('barang_id', $barang->id)->delete();
            Keluar::where('barang_id', $barang->id)->delete();
            Peminjaman::where('barang_id', $barang->id)->delete();
         
            if ($status->jenis === 'masuk') {
                Masuk::create([
                    'barang_id'     => $barang->id,
                    'tanggal_masuk' => $validatedData['tanggal_masuk'],
                ]);
                DB::commit();
                return to_route('masuk.index')->with('success', 'Barang masuk berhasil diubah');
            }

            if ($status->jenis === 'keluar') {
                Keluar::create([
                    'barang_id'         => $barang->id,
                    'tanggal_keluar'    => $validatedData['tanggal_keluar'],
                ]);
                DB::commit();
                return to_route('keluar.index')->with('success', 'Barang keluar berhasil diubah');

            }
                
            if ($status->jenis === 'peminjaman') {
                try {
                            Peminjaman::create([
                    'barang_id'       => $barang->id,
                    'nomor_surat'     => $validatedData['nomor_surat'],
                    'tanggal_bastp'   => $validatedData['tanggal_bastp'],
                    'tanggal_selesai' => $validatedData['tanggal_selesai'],
                    'pic'             => Auth::user()->id,
                ]);
                } catch (\Throwable $th) {
                    dd($th);
                }
        
                
                DB::commit();
                return to_route('peminjaman.index')->with('success', 'Peminjaan barang berhasil diubah');;
            }



        } catch (\Exception $e) {
            dd("error");
            DB::rollBack();
                return redirect()->back()->withErrors("error","Gagal mengubah barang");
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $barang = Barang::findOrFail($id);

            Masuk::where('barang_id', $barang->id)->delete();
            Keluar::where('barang_id', $barang->id)->delete();
            Peminjaman::where('barang_id', $barang->id)->delete();

            $barang->delete();

            DB::commit();
            return response()->json(['message' => 'Data barang berhasil dihapus.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}