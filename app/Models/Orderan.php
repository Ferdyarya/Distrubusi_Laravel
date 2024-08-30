<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_barang_keluar','qty','id_barangkeluar','id_pembelian'
   ];
   public function mastertoko()
    {
        return $this->hasOne(Pendafoutlite::class, 'id', 'id_toko');
    }

    public function masterbarang()
    {
        return $this->belongsToMany(Brgmasuk::class, 'id', 'id_barang_keluar');
    }

    public function brgKeluar()
    {
        return $this->hasMany(Brgkeluar::class, 'id_pembelian');
    }



}
