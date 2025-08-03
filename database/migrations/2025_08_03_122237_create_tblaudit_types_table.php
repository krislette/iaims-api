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
        Schema::create('tblaudit_types', function (Blueprint $table) {
            $table->tinyInteger('aud_typ_id')->primary();
            $table->string('aud_typ_name', 50);
            $table->tinyInteger('aud_typ_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblaudit_types');
    }
};
