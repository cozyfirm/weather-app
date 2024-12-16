<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('base__five_days_forecast', function (Blueprint $table) {
            $table->id();

            /** Connect on API key city */
            $table->unsignedBigInteger('city_key');
            $table->foreign('city_key')
                ->references('key')
                ->on('base__cities')
                ->onDelete('cascade');

            $table->date('date');
            $table->tinyInteger('metric')->default(true);

            /**
             *  Sun and moon info
             */
            $table->dateTime('sunrise');
            $table->dateTime('sunset');
            $table->dateTime('moonrise');
            $table->dateTime('moonset');

            /**
             *  Global temperature info
             */
            $table->string('min_temp', 10)->nullable();
            $table->string('min_temp_rf', 10)->nullable();
            $table->string('min_temp_desc', 100)->nullable();

            $table->string('max_temp', 10)->nullable();
            $table->string('max_temp_rf', 10)->nullable();
            $table->string('max_temp_desc', 100)->nullable();

            /** Hours of sun that day */
            $table->string('hours_of_sun', 10)->nullable();

            /** UV Index values */
            $table->string('uv_index', 10)->default(1);
            $table->string('uv_index_desc', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__five_days_forecast');
    }
};
