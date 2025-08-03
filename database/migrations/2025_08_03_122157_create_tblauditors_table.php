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
        Schema::create('tblauditors', function (Blueprint $table) {
            $table->integer('aur_id')->primary();
            $table->string('aur_name_last', 50);
            $table->string('aur_name_first', 50);
            $table->string('aur_name_middle', 50);
            $table->string('aur_name_prefix', 20);
            $table->string('aur_name_suffix', 10);
            $table->tinyInteger('aur_external');
            $table->string('aur_position', 150);
            $table->tinyInteger('aur_salary_grade');
            $table->integer('aur_agn_id');
            $table->string('aur_expertise', 255);
            $table->string('aur_email', 100);
            $table->date('aur_birthdate');
            $table->string('aur_contact_no', 50);
            $table->char('aur_tin', 12);
            $table->tinyInteger('aur_status');
            $table->string('aur_photo', 255);
            $table->tinyInteger('aur_active');
            $table->timestamps();

            $table->foreign('aur_agn_id')->references('agn_id')->on('tblagencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblauditors');
    }
};
