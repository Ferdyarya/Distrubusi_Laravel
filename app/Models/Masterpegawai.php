<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masterpegawai extends Model
{
    use HasFactory;
    // protected $dates = ['tanggal'];
    protected $fillable = [
        'kode', 'nama', 'no_telp'
    ];
}
