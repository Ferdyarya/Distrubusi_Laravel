<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mastertoko extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode', 'namatoko', 'pemilik','alamat'
    ];
}
