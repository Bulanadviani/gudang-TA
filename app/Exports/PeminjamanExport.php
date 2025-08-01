<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Peminjaman::join('barang', 'peminjaman.barang_id', '=', 'barang.id')
            ->leftJoin('merk', 'barang.merk_id', '=', 'merk.id')
            ->leftJoin('kategori', 'barang.kategori_id', '=', 'kategori.id')
            ->leftJoin('keadaan', 'barang.keadaan_id', '=', 'keadaan.id')
            ->leftJoin('lokasi', 'barang.lokasi_id', '=', 'lokasi.id')
            ->leftJoin('status', 'barang.status_id', '=', 'status.id')
            ->leftJoin('users', 'peminjaman.pic', '=', 'users.id')
            ->select([
                'peminjaman.id as peminjaman_id',
                'barang.kode_rak',
                'barang.serial_number',
                'barang.kode_material',
                'merk.nama as merk',
                'barang.spesifikasi',
                'kategori.nama as kategori',
                'keadaan.nama as keadaan',
                'lokasi.nama as lokasi',
                'status.nama as status',
                'barang.keterangan as keterangan_barang',
                'peminjaman.nomor_surat',
                'peminjaman.tanggal_bastp',
                'peminjaman.tanggal_selesai',
                'users.name as pic',
                'peminjaman.created_at',
                'peminjaman.updated_at'
            ])
            ->get();
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
                'Keterangan Barang' => $item->keterangan_barang,
                'Nomor Surat' => $item->nomor_surat,
                'Tanggal BASTP' => $item->tanggal_bastp,
                'Tanggal Selesai' => $item->tanggal_selesai,
                'PIC' => $item->pic,
                'Tanggal Dibuat' => $item->created_at,
                'Tanggal Diubah' => $item->updated_at,
            ]);
        });
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
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
            'Nomor Surat',
            'Tanggal BASTP',
            'Tanggal Selesai',
            'PIC',
            'Tanggal Dibuat',
            'Tanggal Diubah',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
