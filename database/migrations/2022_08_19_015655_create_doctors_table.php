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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('doctor_id');
            $table->string('doctor_name');
            $table->string('doctor_email');
            $table->string('doctor_phone')->nullable();
            $table->string('doctor_speciality');
            $table->string('password');
            $table->string('doctor_picture')->default('default-avatar.png');
            $table->string('today_appointments')->nullable();
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
        Schema::dropIfExists('doctors');
    }
};
