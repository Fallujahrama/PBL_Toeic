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
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->string('nim')->index();
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->string('file_ktp')->nullable();
            $table->string('file_ktm')->nullable();
            $table->string('file_foto')->nullable();
            $table->string('file_bukti_pembayaran')->nullable(); 
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
