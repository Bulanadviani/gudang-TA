<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Masuk extends Model
{
    use HasFactory;

    protected $table = 'masuk';

    protected $fillable = [
        'barang_id',
        'tanggal_masuk',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
