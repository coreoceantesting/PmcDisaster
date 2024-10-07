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
        Schema::create('closure_details', function (Blueprint $table) {
            $table->id();
            $table->integer('complaint_id')->nullable();
            $table->integer('no_of_male_injured')->nullable();
            $table->integer('no_of_female_injured')->nullable();
            $table->integer('no_of_child_injured')->nullable();
            $table->integer('total_injured')->nullable();
            $table->integer('no_of_male_death')->nullable();
            $table->integer('no_of_female_death')->nullable();
            $table->integer('no_of_child_death')->nullable();
            $table->integer('total_death')->nullable();
            $table->text('remark')->nullable();
            $table->string('upload_doc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closure_details');
    }
};
