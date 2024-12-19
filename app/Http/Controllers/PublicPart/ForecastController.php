<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Traits\API\LocationsTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ForecastController extends Controller{
    use ResponseTrait, LocationsTrait;

    protected string $_path = 'public-part.app.forecast.';

    public function search(): View{
        return view($this->_path . 'search');
    }
    public function preview(): View{
        return view($this->_path . 'preview');
    }
    public function previewDay(): View{
        return view($this->_path . 'preview-day');
    }

    /** ------------------------------------------------------------------------------------------------------------ **/
    /**
     *  API routes
     */
    public function searchByText(Request $request): JsonResponse{
        try{
            $jsonResponse = [];
            if(isset($request->term)) {
                $response = $this->searchBy("cities/autocomplete", $request->term);

                foreach($response as $data){
                    $jsonResponse[] = [
                        'id' => $data->Key,
                        'title' => $data->LocalizedName,
                        'description' => $data->Country->LocalizedName ?? ''
                    ];
                }
            }else{
                return $this->apiResponse('5020', __('Uneseni podaci nisu validni'));
            }

            return $this->apiResponse('0000', __('Success'), [
                'data' => $jsonResponse
            ]);

        }catch (\Exception $e){
            Log::channel('api')->info($e->getMessage());
            return $this->apiResponse('5000', __('Greška prilikom pretraživanja!!'));
        }
    }
}
