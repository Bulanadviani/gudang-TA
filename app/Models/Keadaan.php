<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keadaan extends Model
{
    use HasFactory;
    protected $table = 'keadaan';
    protected $fillable = ['nama'];
}
