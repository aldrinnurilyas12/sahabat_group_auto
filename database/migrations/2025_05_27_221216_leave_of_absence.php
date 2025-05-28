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
        Schema::create('leave_of_absences', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('employee_id');
            $table->string('type_of_leave');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('reason');
            $table->string('status')->default('pending');
            $table->integer('leave_of_duration');
            $table->string('attachment')->nullable();
            $table->string('approved_by_branch_head')->nullable();
            $table->string('approved_by_hr')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by');
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_of_absences');
    }
};
