<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use App\Models\Masterpegawai;

use App\Models\Masterbarang;
use App\Models\User;
use App\Models\Mastertoko;
use App\Models\Masterpegawai;
use App\Models\Mastersupplier;
use Illuminate\Database\Seeder;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::table('masterpegawais')->insert([
        //     'kode' => '1111',
        //     'nama' => 'Hendra',
        //     'no_telp' => '081999234478',
        // ]);

        // User Data
        User::create([
            'name' => 'Mustakim',
            'email' => 'supervisor@gmail.com',
            'password' => bcrypt('1'),
            'roles' => 'supervisor'
        ]);
        User::create([
            'name' => 'Erwin',
            'email' => 'erwin@gmail.com',
            'password' => bcrypt('2'),
            'roles' => 'sales'
        ]);
        User::create([
            'name' => 'Popo',
            'email' => 'popo@gmail.com',
            'password' => bcrypt('22'),
            'roles' => 'sales'
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('3'),
            'roles' => 'admin'
        ]);
        User::create([
            'name' => 'Wendy',
            'email' => 'kepgudang@gmail.com',
            'password' => bcrypt('4'),
            'roles' => 'kepgudang'
        ]);
        User::create([
            'name' => 'Farid',
            'email' => 'helper@gmail.com',
            'password' => bcrypt('5'),
            'roles' => 'helper'
        ]);

        //MasterData
        // Masterpegawai::create([
        //     'kode' => 'MA1',
        //     'nama' => 'Erwin',
        //     'no_telp' => '082399234478'
        // ]);
        // Masterpegawai::create([
        //     'kode' => 'MA2',
        //     'nama' => 'Sandy',
        //     'no_telp' => '083399254321'
        // ]);
        // Masterpegawai::create([
        //     'kode' => 'MA3',
        //     'nama' => 'Saupi',
        //     'no_telp' => '08599921234'
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MA01',
        //     'namatoko' => 'EVA LF',
        //     'pemilik' => 'Hani Fitri',
        //     'alamat' => 'Banjarmasin'
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MA02',
        //     'namatoko' => 'MM GLOW ',
        //     'pemilik' => 'Hj. Gelis',
        //     'alamat' => 'kayutangi'
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MF01',
        //     'namatoko' => 'iyan plastik',
        //     'pemilik' => 'arul',
        //     'alamat' => 'Martapura'
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MF02',
        //     'namatoko' => 'Toko 71',
        //     'pemilik' => 'Ibu Riska',
        //     'alamat' => 'Landasan Ulin'
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MF03',
        //     'namatoko' => 'Toko lampau',
        //     'pemilik' => 'Ibu marsel',
        //     'alamat' => 'guntung manggis '
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MS01',
        //     'namatoko' => 'H.ali ',
        //     'pemilik' => 'Ibu jamiah',
        //     'alamat' => 'Banjarmasin'
        // ]);

        // Mastertoko::create([
        //     'kode' => 'MS02',
        //     'namatoko' => 'Pandawa',
        //     'pemilik' => 'asepbadrun',
        //     'alamat' => 'pasar lima '
        // ]);

        // Mastersupplier::create([
        //     'npwp' => '1234567890124456',
        //     'namapt' => 'PT Graha Bumi Hijau ',
        //     'alamat' => 'SCBD lt 1 no.008',
        //     'email' => 'GrahaBumiHijau@Gmail.com',
        //     'no_telp' => '08553321234'
        // ]);

        // Mastersupplier::create([
        //     'npwp' => '1234567890553358',
        //     'namapt' => 'PT SUMBER ABADI ',
        //     'alamat' => 'SCBD lt 2 no.223',
        //     'email' => 'SUMBERABADI@Gmail.com',
        //     'no_telp' => '08553321234'
        // ]);

        // Mastersupplier::create([
        //     'npwp' => '123456789015796',
        //     'namapt' => 'PT FONTERRA INDONESIA ',
        //     'alamat' => 'SCBD lt 4 no.435',
        //     'email' => 'FONTERRAINDONESIA@Gmail.com',
        //     'no_telp' => '08553321234'
        // ]);

        // Mastersupplier::create([
        //     'npwp' => '1234567890165377',
        //     'namapt' => 'PT SAN ',
        //     'alamat' => 'SCBD lt 10 no.12',
        //     'email' => 'SAN@Gmail.com',
        //     'no_telp' => '08553321234'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'BIHUN PADAMU 300g',
        //     'hargabarang' => '77500'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'ANLENE ACTIFIT SACHET VAN 20G ',
        //     'hargabarang' => '25000'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'ANLENE ACTIFIT SACHET COK 20G',
        //     'hargabarang' => '25000'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'ANLENE GOLD SACHET COK 25G',
        //     'hargabarang' => '29000'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'MULTI MP008',
        //     'hargabarang' => '37000'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'MULTI MP11MU',
        //     'hargabarang' => '22800'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'TP19PA ',
        //     'hargabarang' => '183000'
        // ]);

        // Masterbarang::create([
        //     // 'kodebarang' => 'TOD02B',
        //     'namabarang' => 'KRISPY KING ORI ',
        //     'hargabarang' => '6500'
        // ]);

    }
}
