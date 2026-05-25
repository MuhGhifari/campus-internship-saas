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
        Schema::table('logbook_entries', function (Blueprint $table) {
            $table->foreignId('assigned_by_id')->nullable()->after('student_id')->index();
            $table->date('due_date')->nullable()->after('tanggal');
            $table->timestamp('completed_at')->nullable()->after('status');
            $table->unsignedTinyInteger('score')->nullable()->after('completed_at');
            $table->text('score_notes')->nullable()->after('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook_entries', function (Blueprint $table) {
            $table->dropColumn([
                'assigned_by_id',
                'due_date',
                'completed_at',
                'score',
                'score_notes',
            ]);
        });
    }
};
