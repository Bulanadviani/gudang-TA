<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'barang_id',
        'nomor_surat',
        'tanggal_bastp',
        'tanggal_selesai',
        'pic',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
