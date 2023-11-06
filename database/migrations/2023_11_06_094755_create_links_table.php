<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('links');
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('sites_link');
            $table->unsignedBigInteger('faculty_id');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
