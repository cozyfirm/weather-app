<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Traits\API\LocationsTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BaseCitiesController extends Controller{
    use ResponseTrait, LocationsTrait;

    protected string $_path = 'admin.app.base.cities.';

    public function index(): View{
        $cities = Cities::orderBy('name', 'ASC');
        $cities = Filters::filter($cities);

        $filters = [
            'name' => __('Naziv'),
            'region' => 'Regija',
            'country' => __('Država'),
            'area' => __('Područje'),
            'baseCityRel.name' => __('Bazni grad'),
            'loads' => __('Broj učitavanja')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'cities' => $cities
        ]);
    }
    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true
        ]);
    }
    public function save(Request $request): JsonResponse{
        try{
            if(isset($request->city)){
                $city = $this->searchBy($request->city, null);
                if(isset($city->Key)){
                    $sample = Cities::where('key', '=', $city->Key)->first();
                    if(!$sample){
                        /* Create database object: Cities */
                        $sample = $this->createCityObject($city->Key, $city, true);
                    }

                    return $this->jsonSuccess(__('Uspješno!'), route('system.admin.base.cities.preview', ['id' => $sample->id ]));
                }else{
                    return $this->apiResponse('5011', __('Odabrani grad ne postoji'));
                }
            }else{
                return $this->apiResponse('5010', __('Molimo odaberite grad!'));
            }

        }catch (\Exception $e){}
    }

    public function preview($id): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'city' => Cities::where('id', '=', $id)->first()
        ]);
    }
    public function delete($id): RedirectResponse{
        Cities::where('id', '=', $id)->delete();
        return redirect()->route('system.admin.base.cities');
    }

    /**
     * Fetch cities from API (C-Select-2)
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request): JsonResponse{
        try{
            $jsonResponse = [];
            if(isset($request->term)) {
                $response = $this->searchBy("cities/search", $request->term);

                foreach($response as $data){
                    $jsonResponse[] = [
                        'id' => $data->Key,
                        'title' => $data->LocalizedName,
                        'description' => ($data->AdministrativeArea->LocalizedName ?? '') . ', ' . ($data->Country->LocalizedName ?? '')
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
