<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kode_rak',
        'serial_number',
        'kode_material',
        'merk_id',
        'spesifikasi',
        'kategori_id',
        'keadaan_id',
        'lokasi_id',
        'status_id',
        'keterangan'
    ];

    // Relasi ke tabel status barang
    public function masuk()
    {
        return $this->hasOne(Masuk::class);
    }

    public function keluar()
    {
        return $this->hasOne(Keluar::class);
    }

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class);
    }

    // Relasi ke tabel referensi (FIXED)
    public function merk()
    {
        return $this->belongsTo(Merk::class, 'merk_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function keadaan()
    {
        return $this->belongsTo(Keadaan::class, 'keadaan_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
