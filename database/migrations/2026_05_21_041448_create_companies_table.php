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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->index();
            $table->string('nama');
            $table->string('industri');
            $table->string('alamat')->nullable();
            $table->string('website')->nullable();
            $table->string('kontak_email')->nullable();
            $table->string('kontak_telepon')->nullable();
            $table->string('status')->default('aktif')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
