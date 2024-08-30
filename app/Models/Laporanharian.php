<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporanharian extends Model
{
    use HasFactory;
    protected $casts = [
        'expired_at' => 'tanggal'
    ];
    protected $fillable = [
        'tanggal', 'area', 'chanel', 'call', 'ec', 'akumulasiec', 'targetharian', 'aktualharian','id_sales'
    ];

    public function masteruser()
    {
        return $this->hasOne(User::class, 'id', 'id_sales');
    }
}
