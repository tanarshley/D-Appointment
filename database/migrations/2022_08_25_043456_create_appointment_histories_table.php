<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_histories', function (Blueprint $table) {
            $table->id('app_history_id');
            $table->integer('appointment_id');
            $table->integer('patient_id');
            $table->string('patient_name');
            $table->integer('doctor_id');
            $table->string('doctor_name');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('appointment_status');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_histories');
    }
};
