<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mastersupplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'namapt', 'alamat', 'email', 'no_telp'
    ];
}
