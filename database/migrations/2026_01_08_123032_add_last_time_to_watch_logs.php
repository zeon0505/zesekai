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
        Schema::table('watch_logs', function (Blueprint $table) {
            $table->integer('last_time')->default(0)->after('episode_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('watch_logs', function (Blueprint $table) {
            $table->dropColumn('last_time');
        });
    }
};
