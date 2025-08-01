<?php

namespace App\Exports;

use App\Models\Barang; // Asumsi model utama adalah Barang
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasukExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
{
    $data = Barang::join('masuk', 'barang.id', '=', 'masuk.barang_id')
        ->leftJoin('merk', 'barang.merk_id', '=', 'merk.id')
        ->leftJoin('kategori', 'barang.kategori_id', '=', 'kategori.id')
        ->leftJoin('keadaan', 'barang.keadaan_id', '=', 'keadaan.id')
        ->leftJoin('lokasi', 'barang.lokasi_id', '=', 'lokasi.id')
        ->leftJoin('status', 'barang.status_id', '=', 'status.id')
        ->select([
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
        ])
        ->get();

    // Tambahkan nomor urut (No) secara manual
    $dataWithNumber = $data->map(function ($item, $index) {
        return collect([
            'No' => $index + 1, // mulai dari 1
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
            'Tanggal Masuk' => $item->tanggal_masuk,
            'Tanggal Dibuat' => $item->created_at,
            'Tanggal Diubah' => $item->updated_at,
        ]);
    });

    return $dataWithNumber;
}


    public function headings(): array
{
    return [
        'No',
        'Kode Rak',
        'Serial Number',
        'Kode Material',
        'Merk',
        'Spesifikasi',
        'Kategori',
        'Keadaan',
        'Lokasi',
        'Status',
        'Keterangan',
        'Tanggal Masuk',
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