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
        Schema::create('base__cities', function (Blueprint $table) {
            $table->id();

            $table->integer('key'); // Key for specific city

            $table->string('name');
            $table->string('name_eng');

            $table->string('region_id');     // EUR
            $table->string('region');        // Evropa
            $table->string('region_eng');    // Europe

            $table->string('country_id');    // BA
            $table->string('country');       // Bosna i Hercegovina
            $table->string('country_eng');   // Bosnia and Herzegovina

            $table->string('area_id')->nullable();    // BIH
            $table->string('area')->nullable();       // Federacija Bosne i Hercegovine
            $table->string('area_eng')->nullable();   // Federation of Bosnia and Herzegovina

            $table->string('latitude');
            $table->string('longitude');
            $table->string('elevation');   // Metric system

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__cities');
    }
};
