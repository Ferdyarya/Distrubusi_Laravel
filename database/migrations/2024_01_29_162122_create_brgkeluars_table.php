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
        Schema::create('brgkeluars', function (Blueprint $table) {
            $table->id();
            $table->string('id_toko');
            $table->string('noinvoice')->nullable()->unique();
            $table->string('nosuratjalan')->nullable()->unique();
            $table->string('nopembelian')->nullable()->unique();
            $table->string('statuskirim')->nullable();
            $table->string('bukti')->nullable();
            $table->date('tanggal');
            $table->date('updatekirim');
            $table->integer('id_sales');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brgkeluars');
    }
};
