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
        Schema::create('tblagencies', function (Blueprint $table) {
            $table->integer('agn_id')->primary()->autoIncrement();
            $table->string('agn_name', 255);
            $table->string('agn_acronym', 30);
            $table->char('agn_grp_code', 2);
            $table->string('agn_address', 255);
            $table->string('agn_head_name', 150);
            $table->string('agn_head_position', 150);
            $table->text('agn_contact_details');
            $table->tinyInteger('agn_active')->default(1);
            $table->timestamps();

            $table->foreign('agn_grp_code')->references('agn_grp_code')->on('tblagency_groupings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblagencies');
    }
};
