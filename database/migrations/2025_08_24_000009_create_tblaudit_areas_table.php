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
        Schema::create('tblaudit_areas', function (Blueprint $table) {
            $table->tinyInteger('ara_id')->primary()->autoIncrement();
            $table->string('ara_name', 255);
            $table->tinyInteger('ara_ara_id')->nullable();
            $table->tinyInteger('ara_active');
            $table->timestamps();

            $table->foreign('ara_ara_id')->references('ara_id')->on('tblaudit_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblaudit_areas');
    }
};
