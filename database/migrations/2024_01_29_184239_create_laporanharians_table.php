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
        Schema::create('laporanharians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            // $table->string('id_pegawai');
            $table->string('area');
            $table->string('chanel');
            $table->string('call');
            // $table->string('ec');
            $table->integer('id_sales');
            $table->string('akumulasiec');
            $table->string('targetharian');
            $table->string('aktualharian');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporanharians');
    }
};
