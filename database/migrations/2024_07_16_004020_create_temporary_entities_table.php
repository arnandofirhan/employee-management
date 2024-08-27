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
        Schema::create('temporary_entities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaction_code')->index();

            $table->string('full_name');
            $table->tinyInteger('gender_category')->nullable()->default(1);
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('phone')->nullable();
            $table->text('identity_full_address')->nullable();
            $table->date('join_date')->nullable();
            $table->uuid('department_id')->index()->nullable();
            $table->string('job_placement')->nullable();
            $table->uuid('employee_status_id')->index()->nullable();
            $table->text('note')->nullable();

            $table->boolean('is_active')->default(1);

            $table->boolean('is_validated')->default(1);
            $table->json('notes')->nullable();
            $table->uuid('created_by')->index()->nullable();
            $table->uuid('updated_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporary_entities');
    }
};
