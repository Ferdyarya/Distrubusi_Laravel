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
        Schema::create('brgmasuks', function (Blueprint $table) {
            $table->id();
            $table->string('kodebarang')->nullable();
            $table->string('id_supplier');
            $table->string('namabarang')->unique();
            $table->string('qty');
            $table->date('tanggal');
            $table->string('hargabarang');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brgmasuks');
    }
};
