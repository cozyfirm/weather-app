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
        Schema::create('base__five_days_forecast_info', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')
                ->references('key')
                ->on('base__five_days_forecast')
                ->onDelete('cascade');

            $table->string('type', 10)->default('day'); // Day or Night

            $table->string('icon');
            $table->string('phrase')->nullable();
            $table->string('short_phrase')->nullable();
            $table->string('long_phrase')->nullable();

            $table->tinyInteger('has_precipitation')->default(false);        // true | false
            $table->string('precipitation_type', 100)->nullable();          // Rain
            $table->string('precipitation_intensity', 100)->nullable();     // Light

            /**
             *  Precipitation infos
             */
            $table->string('precipitation_probability', 5)->default('0');
            $table->string('thunderstorm_probability', 5)->default('0');
            $table->string('rain_probability', 5)->default('0');
            $table->string('snow_probability', 5)->default('0');
            $table->string('ice_probability', 5)->default('0');

            /**
             *  Wind info
             */
            $table->string('wind_speed', 10)->default(0);           // Wind speed
            $table->string('wind_gust_speed', 10)->default(0);      // Wind gust speed
            $table->integer('wind_direction_deg')->default(0);             // 0
            $table->string('wind_direction_l', 5)->default('S');    // S - Sjever
            $table->string('wind_direction_e', 5)->default('N');    // N - North

            $table->string('total_liquid', 10)->default('0.0');         // Total liquid in mm
            $table->string('total_rain', 10)->default('0.0');           // Total rain in mm
            $table->string('total_snow', 10)->default('0.0');           // Total snow in cm
            $table->string('total_ice', 10)->default('0.0');            // Total ice in mm

            $table->string('hours_of_precipitation', 10)->default('0.0');   // Total liquid in mm
            $table->string('hours_of__rain', 10)->default('0.0');           // Total rain in mm
            $table->string('hours_of__snow', 10)->default('0.0');           // Total snow in cm
            $table->string('hours_of__ice', 10)->default('0.0');            // Total ice in mm

            $table->string('cloud_cover', 10)->default('0');          // Cloud coverage in percents

            $table->string('rel_humidity_min', 5)->default(0);            // 87 (%) - Humidity
            $table->string('rel_humidity_max', 5)->default(0);            // 87 (%) - Humidity
            $table->string('rel_humidity_avg', 5)->default(0);            // 87 (%) - Humidity


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__five_days_forecast_info');
    }
};
