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
        Schema::create('entity_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('value')->index();
            $table->string('name');
            $table->tinyInteger('sequence')->default(0);
            $table->string('background_color_code')->nullable();
            $table->string('font_color_code')->nullable();

            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('entity_categories');
    }
};
