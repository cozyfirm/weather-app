<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller{
    protected string $_path = 'public-part.app.home.';

    public function home(): View{
        return view($this->_path . 'home', [
            'popularCities' => Cities::inRandomOrder()->take(5)->get(),
            'currentCity' => Cities::where('key', '=', 33028)->first()
        ]);
    }
}
