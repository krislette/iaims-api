<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblaudit_criteria', function (Blueprint $table) {
            $table->integer('cra_id')->primary();
            $table->string('cra_name', 255);
            $table->string('cra_areas', 100);
            $table->string('cra_references', 255);
            $table->tinyInteger('cra_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblaudit_criteria');
    }
};
