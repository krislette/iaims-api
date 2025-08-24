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
            $table->integer('aur_id')->primary()->autoIncrement();
            $table->string('aur_name_last', 50);
            $table->string('aur_name_first', 50);
            $table->string('aur_name_middle', 50)->nullable();
            $table->string('aur_name_prefix', 20)->nullable();
            $table->string('aur_name_suffix', 10)->nullable();
            $table->tinyInteger('aur_external')->default(0);
            $table->string('aur_position', 150)->nullable();
            $table->tinyInteger('aur_salary_grade')->default(1);
            $table->integer('aur_agn_id')->nullable();
            $table->string('aur_expertise', 255)->nullable();
            $table->string('aur_email', 100);
            $table->date('aur_birthdate')->nullable();
            $table->string('aur_contact_no', 50)->nullable();
            $table->char('aur_tin', 12)->nullable();
            $table->tinyInteger('aur_status')->default(1);
            $table->string('aur_photo', 255)->nullable();
            $table->tinyInteger('aur_active')->default(1);
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
