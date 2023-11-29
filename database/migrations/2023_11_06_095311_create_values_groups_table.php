<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('values_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id')->references('id')->on('faculties')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        // Create the intermediate table for the many-to-many relationship
        Schema::create('departament_value_group', function (Blueprint $table) {
            $table->unsignedBigInteger('departament_id')->nullable();
            $table->foreign('departament_id')->references('id')->on('departament')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('values_groups')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('departament_value_group');
        Schema::dropIfExists('values_groups');
    }
};
