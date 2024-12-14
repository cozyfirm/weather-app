<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForecastController extends Controller{
    protected string $_path = 'public-part.app.forecast.';

    public function search(): View{
        return view($this->_path . 'search');
    }

    public function preview(): View{
        return view($this->_path . 'preview');
    }
}
