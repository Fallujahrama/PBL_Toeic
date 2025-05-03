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
        Schema::create('surat_pernyataan', function (Blueprint $table) {
            $table->id('id_surat_pernyataan');
            $table->string('file_surat_pernyataan');
            $table->string('status')->default('pending');
            $table->string('nim')->index();
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pernyataan');
    }
};
