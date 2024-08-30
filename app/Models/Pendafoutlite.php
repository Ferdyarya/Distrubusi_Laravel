<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendafoutlite extends Model
{
    use HasFactory;
    protected $casts = [
        'expired_at' => 'tanggal'
    ];
    protected $fillable = [
         'tanggal', 'namatoko', 'pemiliktoko', 'alamat', 'domisili', 'no_telp', 'fotoktp', 'status','fototoko','id_sales'
    ];

    public function masteruser()
    {
        return $this->hasOne(User::class, 'id', 'id_sales');
    }
}
