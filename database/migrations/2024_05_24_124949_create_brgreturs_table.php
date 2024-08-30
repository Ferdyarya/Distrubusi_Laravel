<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brgreturs', function (Blueprint $table) {
            $table->id();
            $table->string('id_barang');
            $table->string('keluhan');
            $table->string('id_customer');
            // $table->string('id_pegawai');
            $table->date('tanggal');
            $table->string('qty');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brgreturs');
    }
};
