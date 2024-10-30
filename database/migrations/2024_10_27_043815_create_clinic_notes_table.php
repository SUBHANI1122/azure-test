<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->nullable()->constrained('appoinments')->onDelete('cascade'); // Foreign key to appointments table
            $table->boolean('dm')->default(false); // Diabetes Mellitus
            $table->boolean('ht')->default(false); // Hypertension
            $table->string('bp')->nullable(); // Blood Pressure
            $table->string('pc')->nullable(); // Presenting Complaint
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
        Schema::dropIfExists('clinic_notes');
    }
}
