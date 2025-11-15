<?php

use App\Http\Controllers\API\ForecastController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/forecast')->middleware('api-auth')->group(function (){

    /** Popular cities */
    Route::post('/popular-cities',                   [ForecastController::class, 'popularCities'])->name('api.forecast.popular-cities');

    /**
     *  City info:
     *      1. Preview city
     *      2. Preview by day
     *      3. Preview by night
     */

    Route::prefix('/cities')->middleware('api-auth')->group(function (){
        Route::post('/preview-city',                 [ForecastController::class, 'previewCity'])->name('api.forecast.cities.preview-city');
        /** Today, tomorrow and / or by date */
        Route::post('/preview-by-date',              [ForecastController::class, 'previewByDate'])->name('api.forecast.cities.preview-by-date');

        /** Get city slug */
        Route::post('/get-city-slug',                [ForecastController::class, 'getCitySlug'])->name('api.forecast.cities.get-city-slug');
    });
});
