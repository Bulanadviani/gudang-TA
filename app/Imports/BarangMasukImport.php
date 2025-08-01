<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Masuk;
use App\Models\Merk;
use App\Models\Kategori;
use App\Models\Keadaan;
use App\Models\Lokasi;
use App\Models\Status;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BarangMasukImport implements ToCollection
{
    protected $duplicateSerials = [];

    public function collection(Collection $rows)
    {
        $status = Status::firstOrCreate(
            ['jenis' => 'masuk'],
            ['nama' => 'Masuk']
        );

        $rows->skip(1)->each(function ($row, $index) use ($status) {
            DB::transaction(function () use ($row, $status, $index) {

                if (Barang::where('serial_number', $row[1])->exists()) {
                    $this->duplicateSerials[] = $row[1];
                    return;
                }

                $merk     = Merk::firstOrCreate(['nama' => $row[3]]);
                $kategori = Kategori::firstOrCreate(['nama' => $row[5]]);
                $keadaan  = Keadaan::firstOrCreate(['nama' => $row[6]]);
                $lokasi   = Lokasi::firstOrCreate(['nama' => $row[7]]);

                $barang = Barang::create([
                    'kode_rak'      => $row[0],
                    'serial_number' => $row[1],
                    'kode_material' => $row[2],
                    'merk_id'       => $merk->id,
                    'spesifikasi'   => $row[4],
                    'kategori_id'   => $kategori->id,
                    'keadaan_id'    => $keadaan->id,
                    'lokasi_id'     => $lokasi->id,
                    'status_id'     => $status->id,
                    'keterangan'    => $row[8],
                ]);

                $tanggalMasuk = !empty($row[9]) ? Date::excelToDateTimeObject($row[9]) : now();

                Masuk::create([
                    'barang_id'     => $barang->id,
                    'tanggal_masuk' => $tanggalMasuk,
                ]);
            });
        });

        // Simpan ke session untuk ditampilkan
        if (!empty($this->duplicateSerials)) {
            Session::flash('duplikat_serial', $this->duplicateSerials);
        }
    }
}


