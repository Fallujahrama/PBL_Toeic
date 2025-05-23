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
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Add verification status field if it doesn't exist
            if (!Schema::hasColumn('pendaftaran', 'status_verifikasi')) {
                $table->string('status_verifikasi')->nullable()->default('pending');
            }
            
            // Add verification notes field if it doesn't exist
            if (!Schema::hasColumn('pendaftaran', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftaran', 'status_verifikasi')) {
                $table->dropColumn('status_verifikasi');
            }
            
            if (Schema::hasColumn('pendaftaran', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
