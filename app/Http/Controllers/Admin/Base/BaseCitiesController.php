<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BaseCitiesController extends Controller{
    use ResponseTrait;

    protected string $_path = 'admin.app.base.cities.';

    public function index(): View{
        $cities = Cities::where('id', '>', 0);
        $cities = Filters::filter($cities);

        $filters = [
            'name' => __('Naziv'),
            'region' => 'Regija',
            'country' => __('Država'),
            'area' => __('Područje')
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

    public function fetch(Request $request): bool|string{
        try{
            return $this->jsonResponse('0000', __('Success'), [
                'data' => [
                    0 => [
                        'id' => 1,
                        'title' => 'Test 1 ',
                        'city' => 'Test 2'
                    ],
                    1 => [
                        'id' => 2,
                        'title' => 'Test 2',
                        'city' => 'Test 2'
                    ]
                ]
            ]);

        }catch (\Exception $e){}
    }
}
