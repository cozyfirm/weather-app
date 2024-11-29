<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BaseCitiesController extends Controller{
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
}
