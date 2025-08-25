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
        Schema::create('tblinternal_control_components', function (Blueprint $table) {
            $table->integer('com_ic_id');
            $table->tinyInteger('com_seqnum');
            $table->string('com_desc', 300);
            $table->timestamps();

            $table->primary(['com_ic_id', 'com_seqnum']);

            $table->foreign('com_ic_id')->references('ic_id')->on('tblinternal_controls');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblinternal_control_components');
    }
};
