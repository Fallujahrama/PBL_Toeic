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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('nama')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('alamat_asal')->nullable();
            $table->string('nik')->nullable();
            $table->bigInteger('no_whatsapp')->nullable();
            $table->string('kampus')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('alamat_saat_ini')->nullable();
            $table->foreign('user_id')->references('id_user')->on('m_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
