<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('added_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('size');
            $table->string('meal_timing')->default('before');
            $table->boolean('morning')->default(false);
            $table->boolean('afternoon')->default(false);
            $table->boolean('evening')->default(false);
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
        Schema::dropIfExists('medicines');
    }
}
