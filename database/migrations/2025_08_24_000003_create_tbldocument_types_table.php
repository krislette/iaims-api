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
        Schema::create('tbldocument_types', function (Blueprint $table) {
            $table->tinyInteger('doc_typ_id')->primary()->autoIncrement();
            $table->string('doc_typ_name', 100);
            $table->tinyInteger('doc_typ_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbldocument_types');
    }
};
