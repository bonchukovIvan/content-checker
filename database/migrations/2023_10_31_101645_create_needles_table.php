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
        Schema::create('needles', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->unsignedBigInteger('haystack_id');
            $table->foreign('haystack_id')->references('id')->on('haystacks')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('needles');
    }
};
