<?php

namespace App\Models;

use App\Models\Orderan;
use App\Models\User;
use App\Models\Pendafoutlite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brgkeluar extends Model
{
    use HasFactory;
    protected $casts = [
        'expired_at' => 'tanggal'
    ];
    protected $fillable = [
         'updatekirim','id_user','qty', 'tanggal', 'id_toko','id_barang','noinvoice','nosuratjalan','nopembelian','id_barang_keluar','id_qty','id_sales'
    ];


    public function mastertoko()
    {
        return $this->hasOne(Pendafoutlite::class, 'id', 'id_toko');
    }

    public function masterbarang()
    {
        return $this->hasOne(Brgmasuk::class, 'id', 'id_barang');
    }

    public function orderan()
    {
        return $this->hasMany(Orderan::class, 'id_pembelian');
    }

    public function masteruser()
    {
        return $this->hasOne(User::class, 'id', 'id_sales');
    }
}
