<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppoinmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appoinments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('users')->onDelete('cascade'); // Assumes patients are stored in users table
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('procedure_name')->nullable();
            $table->decimal('procedure_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('appointment_date'); //
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
        Schema::dropIfExists('appoinments');
    }
}
