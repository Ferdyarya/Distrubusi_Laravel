<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgmasuk extends Model
{
    use HasFactory;
    protected $casts = [
        'expired_at' => 'tanggal'
    ];
    protected $fillable = [
        'kodebarang','id_supplier', 'namabarang', 'qty', 'tanggal','hargabarang','status'
    ];

    public function mastersupplier()
    {
        return $this->hasOne(Mastersupplier::class, 'id', 'id_supplier');
    }
    
}
