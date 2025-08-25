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
        Schema::create('tblcalendar_event', function (Blueprint $table) {
            $table->bigInteger('evn_id')->primary();
            $table->string('evn_name', 255);
            $table->tinyInteger('evn_typ_id');
            $table->date('evn_date_start');
            $table->date('evn_date_end');
            $table->time('evn_time_start');
            $table->time('evn_time_end');
            $table->tinyInteger('evn_frequency');
            $table->tinyInteger('evn_interval');
            $table->tinyInteger('evn_month');
            $table->string('evn_week', 14);
            $table->tinyInteger('evn_day');
            $table->tinyInteger('evn_weekday');
            $table->text('evn_remarks');
            $table->timestamps();

            $table->foreign('evn_typ_id')->references('evn_typ_id')->on('tblcalendar_event_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblcalendar_event');
    }
};
