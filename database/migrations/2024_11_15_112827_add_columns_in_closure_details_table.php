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
        Schema::table('closure_details', function (Blueprint $table) {
            $table->string('loss_type')->after('upload_doc')->nullable();
            $table->text('description')->after('loss_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closure_details', function (Blueprint $table) {
            $table->dropColumn('loss_type');
            $table->dropColumn('description');
        });
    }
};
