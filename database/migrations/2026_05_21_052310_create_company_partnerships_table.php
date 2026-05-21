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
        Schema::create('company_partnerships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->index();
            $table->foreignId('university_id')->index();
            $table->foreignId('requested_by')->nullable()->index();
            $table->foreignId('reviewed_by')->nullable()->index();
            $table->string('status')->default('menunggu')->index();
            $table->text('pesan')->nullable();
            $table->text('catatan_review')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['company_id', 'university_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_partnerships');
    }
};
