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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_unique_id')->nullable();
            $table->integer('complaint_type')->nullable();
            $table->integer('complaint_sub_type')->nullable();
            $table->string('manual_complaint_no')->nullable();
            $table->string('caller_name')->nullable();
            $table->string('caller_mobile_no')->nullable();
            $table->text('caller_address')->nullable();
            $table->text('complaint_details')->nullable();
            $table->string('location')->nullable();
            $table->string('departments')->nullable();
            $table->string('uploaded_doc')->nullable();
            $table->enum('approval_status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('approval_remark')->nullable();
            $table->integer('approval_by')->nullable();
            $table->date('approval_at')->nullable();
            $table->enum('closing_status', ['Pending', 'Approved', 'Rejected', 'Closed'])->default('Pending');
            $table->string('closing_remark')->nullable();
            $table->integer('closing_by')->nullable();
            $table->date('closing_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
