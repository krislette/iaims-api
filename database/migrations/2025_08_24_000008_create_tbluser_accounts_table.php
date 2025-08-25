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
        Schema::create('tbluser_accounts', function (Blueprint $table) {
            $table->integer('usr_id')->primary()->autoIncrement();
            $table->string('usr_name', 150);
            $table->integer('usr_aur_id');
            $table->tinyInteger('usr_level');
            $table->string('usr_email', 100);
            $table->char('usr_password', 64);
            $table->tinyInteger('usr_active');
            $table->tinyInteger('usr_logged');
            $table->timestamps();

            $table->foreign('usr_aur_id')->references('aur_id')->on('tblauditors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbluser_accounts');
    }
};
