<?php

namespace App\Exports;

use App\Models\Keluar; // We'll start from Keluar and join to Barang
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KeluarExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
{
    $data = Keluar::join('barang', 'keluar.barang_id', '=', 'barang.id')
        ->leftJoin('merk', 'barang.merk_id', '=', 'merk.id')
        ->leftJoin('kategori', 'barang.kategori_id', '=', 'kategori.id')
        ->leftJoin('keadaan', 'barang.keadaan_id', '=', 'keadaan.id')
        ->leftJoin('lokasi', 'barang.lokasi_id', '=', 'lokasi.id')
        ->leftJoin('status', 'barang.status_id', '=', 'status.id')
        ->select([
            'barang.kode_rak as kode_rak',
            'barang.serial_number as serial_number',
            'barang.kode_material as kode_maretial',
            'merk.nama as merk',
            'barang.spesifikasi as spesifikasi',
            'kategori.nama as kategori',
            'keadaan.nama as keadaan',
            'lokasi.nama as lokasi',
            'status.nama as status',
            'barang.keterangan as keterangan',
            'keluar.tanggal_keluar as tanggal_keluar',
            'keluar.created_at as created_at',
            'keluar.updated_at as updated_at'
        ])->get();

    // Tambahkan nomor urut
    $dataWithNumber = $data->map(function ($item, $index) {
        return collect ([
            'No' => $index + 1,
            'Kode Rak' => $item->kode_rak,
            'Serial Number' => $item->serial_number,
            'Kode Material' => $item->kode_material,
            'Merk' => $item->merk,
            'Spesifikasi' => $item->spesifikasi,
            'Kategori' => $item->kategori,
            'Keadaan' => $item->keadaan,
            'Lokasi' => $item->lokasi,
            'Status' => $item->status,
            'Keterangan' => $item->keterangan,
            'Tanggal Keluar' => $item->tanggal_keluar,
            'Tanggal Dibuat' => $item->created_at,
            'Tanggal Diubah' => $item->updated_at,
        ]);
    });

    return $dataWithNumber;
}


    public function headings(): array
    {
        return [
            'ID Keluar',
            'Kode Rak',
            'Serial Number',
            'Kode Material',
            'Merk',
            'Spesifikasi',
            'Kategori',
            'Keadaan',
            'Lokasi',
            'Status',
            'Keterangan Barang',
            'Tanggal Keluar',
            'Tanggal Dibuat',
            'Tanggal Diubah',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style for the first row (header)
            1 => ['font' => ['bold' => true]],
        ];
    }
}