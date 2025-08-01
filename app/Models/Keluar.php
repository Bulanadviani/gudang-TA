<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluar extends Model
{
    use HasFactory;

    protected $table = 'keluar';

    protected $fillable = [
        'barang_id',
        'tanggal_keluar',
        'bukti_pengeluaran',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
