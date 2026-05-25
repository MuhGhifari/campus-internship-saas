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
        Schema::create('internship_offer_universities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_offer_id')->index();
            $table->foreignId('university_id')->index();
            $table->foreignId('requested_by')->nullable()->index();
            $table->foreignId('reviewed_by')->nullable()->index();
            $table->string('status')->default('menunggu')->index();
            $table->text('catatan_review')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['internship_offer_id', 'university_id'], 'offer_university_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_offer_universities');
    }
};
