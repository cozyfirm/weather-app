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
        Schema::create('search__history', function (Blueprint $table) {
            $table->id();

            /** Connect on API key city */
            $table->unsignedBigInteger('city_key');
            $table->foreign('city_key')
                ->references('key')
                ->on('base__cities')
                ->onDelete('cascade');
            /* User IP Address */
            $table->string('ip_addr');
            /* How many times this user loaded this city */
            $table->integer('loads')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search__history');
    }
};
