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
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('action_remark')->after('closing_at')->nullable();
            $table->integer('action_taken_by')->after('action_remark')->nullable();
            $table->datetime('action_taken_at')->after('action_taken_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('action_remark');
            $table->dropColumn('action_taken_by');
            $table->dropColumn('action_taken_at');
        });
    }
};
