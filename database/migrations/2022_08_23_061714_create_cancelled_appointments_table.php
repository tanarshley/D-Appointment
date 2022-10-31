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
        Schema::create('cancelled_appointments', function (Blueprint $table) {
            $table->id('cancelled_id');
            $table->integer('appointment_id');
            $table->string('patient_id');
            $table->string('patient_name');
            $table->string('doctor_id');
            $table->string('doctor_name');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('appointment_status');
            $table->string('reason');
            $table->string('specify_reason')->nullable();
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
        Schema::dropIfExists('cancelled_appointments');
    }
};
