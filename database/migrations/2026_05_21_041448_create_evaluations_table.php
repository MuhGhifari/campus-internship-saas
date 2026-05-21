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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_application_id')->index();
            $table->foreignId('evaluator_id')->index();
            $table->string('tipe');
            $table->unsignedTinyInteger('nilai_komunikasi')->default(0);
            $table->unsignedTinyInteger('nilai_kedisiplinan')->default(0);
            $table->unsignedTinyInteger('nilai_teknis')->default(0);
            $table->unsignedTinyInteger('nilai_kerja_sama')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['internship_application_id', 'evaluator_id', 'tipe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
