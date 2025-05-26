<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileBuktiPembayaranToPendaftaranTable extends Migration
{
    /**
     * Menambahkan kolom file_bukti_pembayaran ke tabel pendaftaran.
     */
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('file_bukti_pembayaran')->after('file_foto');
        });
    }

    /**
     * Menghapus kolom file_bukti_pembayaran dari tabel pendaftaran.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('file_bukti_pembayaran');
        });
    }
}
