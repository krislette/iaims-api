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
        Schema::create('tblreferences', function (Blueprint $table) {
            $table->integer('ref_id')->primary();
            $table->string('ref_no', 12);
            $table->string('ref_title', 255);
            $table->text('ref_desc');
            $table->tinyInteger('ref_doc_typ_id');
            $table->string('ref_areas', 255);
            $table->string('ref_metadata', 255);
            $table->string('ref_file_path', 255);
            $table->dateTime('ref_upload_date');
            $table->string('ref_upload_by', 150);
            $table->integer('ref_aud_id');
            $table->timestamps();

            $table->foreign('ref_doc_typ_id')->references('doc_typ_id')->on('tbldocument_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblreferences');
    }
};
