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
        Schema::create('internship_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->index();
            $table->foreignId('company_id')->index();
            $table->foreignId('created_by')->nullable()->index();
            $table->string('judul');
            $table->string('bidang');
            $table->string('lokasi');
            $table->string('tipe_kerja')->default('hybrid');
            $table->unsignedInteger('kuota')->default(1);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('batas_lamaran')->nullable()->index();
            $table->text('deskripsi');
            $table->text('persyaratan')->nullable();
            $table->text('benefit')->nullable();
            $table->string('status')->default('menunggu')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_offers');
    }
};
