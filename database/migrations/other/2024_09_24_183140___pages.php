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
        Schema::create('__pages', function (Blueprint $table) {
            $table->id();

            $table->string('title', 150);
            $table->text('description');
            $table->integer('image_id')->nullable();            // Image -> File Rel
            $table->string('yt_link', 200)->nullable();  // YouTube link

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('__pages');
    }
};
