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
        Schema::table('votes', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->nullable()->after('candidate_id'); // ← allow nulls for now

            // Optional: if you're confident your positions table exists already
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');

            // Optional cleanup
            $table->dropColumn('position'); // Only if you're fully switching
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            //
        });
    }
};
