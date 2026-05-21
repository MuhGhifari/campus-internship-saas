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
        Schema::create('internship_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_offer_id')->index();
            $table->foreignId('student_id')->index();
            $table->foreignId('company_supervisor_id')->nullable()->index();
            $table->foreignId('campus_supervisor_id')->nullable()->index();
            $table->string('status')->default('diajukan')->index();
            $table->text('motivasi')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('surat_pengantar_path')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamp('diterima_pada')->nullable();
            $table->timestamps();

            $table->unique(['internship_offer_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_applications');
    }
};
