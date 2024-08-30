<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgretur extends Model
{
    use HasFactory;
    protected $casts = [
        'expired_at' => 'tanggal'
    ];
    protected $fillable = [
        'id_barang','keluhan', 'id_customer', 'qty', 'tanggal'
    ];

    // public function masterpegawai()
    // {
    //     return $this->hasOne(Masterpegawai::class, 'id', 'id_pegawai');
    // }

    public function mastertoko()
    {
        return $this->hasOne(Pendafoutlite::class, 'id', 'id_customer');
    }

    public function masterbarang()
    {
        return $this->hasOne(Brgmasuk::class, 'id', 'id_barang');
    }
}
