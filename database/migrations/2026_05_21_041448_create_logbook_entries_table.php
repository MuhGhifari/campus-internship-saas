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
        Schema::create('logbook_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_application_id')->index();
            $table->foreignId('student_id')->index();
            $table->date('tanggal')->index();
            $table->string('judul_kegiatan');
            $table->text('deskripsi');
            $table->text('kendala')->nullable();
            $table->string('status')->default('menunggu')->index();
            $table->text('catatan_pembimbing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_entries');
    }
};
