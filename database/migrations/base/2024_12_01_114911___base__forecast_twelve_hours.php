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
        Schema::create('base__cities_forecast_th', function (Blueprint $table) {
            $table->id();

            /** Connect on API key city */
            $table->unsignedBigInteger('city_key');
            $table->foreign('city_key')
                ->references('key')
                ->on('base__cities')
                ->onDelete('cascade');

            $table->date('date');
            $table->time('time');
            $table->dateTime('date_time');

            /**
             *  Is metric system or not
             */
            $table->tinyInteger('metric')->default(true);

            $table->string('icon');     // Image ID
            $table->string('phase');    // Oborine | Sunčano

            $table->tinyInteger('has_precipitation')->default(false);        // true | false
            $table->string('precipitation_type', 100)->nullable();          // Rain
            $table->string('precipitation_intensity', 100)->nullable();     // Light

            /* Flag for is it a day or night */
            $table->tinyInteger('is_daylight')->default(false);              // Is day or night: true | false

            /**
             * Temperature info
             */
            $table->string('temperature', 10);                                // Temperature in °C
            $table->string('temperature_rf', 10);                             // Real feel of temperature in °C
            $table->string('temperature_desc', 50)->nullable();               // Hladno
            /* Shade temperature */
            $table->string('temperature_s_rf', 10)->nullable();               // Real feel of temperature in °C
            $table->string('temperature_s_desc', 50)->nullable();             // Hladno

            /**
             *  Dev point
             */
            $table->string('dev_point', 10);

            /**
             *  Wind info
             */
            $table->string('wind_speed', 10)->default(0);           // Wind speed
            $table->string('wind_gust_speed', 10)->default(0);      // Wind gust speed
            $table->integer('wind_direction_deg')->default(0);             // 0
            $table->string('wind_direction_l', 5)->default('S');    // S - Sjever
            $table->string('wind_direction_e', 5)->default('N');    // N - North

            $table->string('rel_humidity', 5)->default(0);            // 87 (%) - Humidity
            $table->string('rel_indoor_humidity', 5)->default(0);     // 87 (%) - Indoor humidity

            /** Visibility */
            $table->string('visibility', 10)->default('0.0');         // 6.4 (km) - Horizontal visibility
            $table->string('ceiling', 10)->default('1000.0');         // 6.4 (km) - Clouds at height
            $table->string('cloud_cover', 10)->default('0');          // Cloud coverage in percents

            /** UV Index */
            $table->string('uv_index', 5)->default('0');     // 0 | 1 | .. | 10
            $table->string('uv_index_text', 20)->nullable();       // Low | Medium | .. | High

            /**
             *  Precipitation infos
             */
            $table->string('precipitation_probability', 5)->default('0');
            $table->string('thunderstorm_probability', 5)->default('0');
            $table->string('rain_probability', 5)->default('0');
            $table->string('snow_probability', 5)->default('0');
            $table->string('ice_probability', 5)->default('0');

            $table->string('total_liquid', 10)->default('0.0');         // Total liquid in mm
            $table->string('total_rain', 10)->default('0.0');           // Total rain in mm
            $table->string('total_snow', 10)->default('0.0');           // Total snow in cm
            $table->string('total_ice', 10)->default('0.0');            // Total ice in mm

            $table->string('solar_irradiance', 10)->default('0.0');     // Radiance in W/m2

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base__cities_forecast_th');
    }
};
