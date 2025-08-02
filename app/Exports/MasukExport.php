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
    // Ambil ID barang yang valid (sudah lengkap relasinya)
    $validBarangIds = Barang::whereNotNull('merk_id')
        ->whereNotNull('lokasi_id')
        ->whereNotNull('kategori_id')
        ->whereNotNull('keadaan_id')
        ->pluck('id');

    // Ambil ID barang yang sudah keluar atau dipinjam
    $barangKeluarIds = \App\Models\Keluar::pluck('barang_id')->toArray();
    $barangPeminjamanIds = \App\Models\Peminjaman::pluck('barang_id')->toArray();
    $barangSudahKeluarAtauDipinjam = array_merge($barangKeluarIds, $barangPeminjamanIds);

    // Ambil data barang masuk yang valid dan belum keluar/dipinjam
    $data = Barang::join('masuk', 'barang.id', '=', 'masuk.barang_id')
        ->leftJoin('merk', 'barang.merk_id', '=', 'merk.id')
        ->leftJoin('kategori', 'barang.kategori_id', '=', 'kategori.id')
        ->leftJoin('keadaan', 'barang.keadaan_id', '=', 'keadaan.id')
        ->leftJoin('lokasi', 'barang.lokasi_id', '=', 'lokasi.id')
        ->leftJoin('status', 'barang.status_id', '=', 'status.id')
        ->whereIn('barang.id', $validBarangIds)
        ->whereNotIn('barang.id', $barangSudahKeluarAtauDipinjam)
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

    // Tambahkan nomor urut
    $dataWithNumber = $data->map(function ($item, $index) {
        return collect([
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