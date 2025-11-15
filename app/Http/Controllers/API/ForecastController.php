<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Traits\Common\LogTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForecastController extends Controller{
    use ResponseTrait, LogTrait;

    /**
     * Get popular cities with temperatures and icons
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function popularCities(Request $request): JsonResponse{
        try{
            $cities = Cities::where('base', '=', 1)
                ->orderBy('name')
                ->take(6)
                ->with('twelveHoursCurrentRel:id,city_key,temperature,icon')
                ->get(['id', 'key', 'slug', 'name']);

            return $this->apiResponse('0000', __('Success'), [
                'cities' => $cities
            ]);
        }catch (\Exception $e){
            $this->write('ForecastController::popularCities()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3000', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }

    /** ------------------------------------------------------------------------------------------------------------- */

    /**
     * Preview city basic info by slug
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function previewCity(Request $request): JsonResponse{
        try{
            dd($request->all());

            return $this->apiResponse('0000', __('Success'), [

            ]);
        }catch (\Exception $e){
            $this->write('ForecastController::popularCities()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3000', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }
}
