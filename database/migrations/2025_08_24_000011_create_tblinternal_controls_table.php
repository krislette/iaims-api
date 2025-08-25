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
        Schema::create('tblinternal_controls', function (Blueprint $table) {
            $table->integer('ic_id')->primary()->autoIncrement();
            $table->tinyInteger('ic_ara_id');
            $table->string('ic_category', 100);
            $table->string('ic_desc', 500);
            $table->tinyInteger('ic_active');
            $table->timestamps();

            $table->foreign('ic_ara_id')->references('ara_id')->on('tblaudit_areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinternal_controls');
    }
};
