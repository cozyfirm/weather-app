<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Models\Base\Cities;
use App\Models\Other\Page;
use App\Traits\API\ForecastTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller{
    use ForecastTrait;
    protected string $_path = 'public-part.app.home.';

    public function home(): View{
        $popular = Cities::where('base', '=', 1)->orderBy('name')->take(6)->get();

        return view($this->_path . 'home', [
            'popularCities' => Cities::inRandomOrder()->take(5)->get(),
            'currentCity' => Cities::where('key', '=', 33028)->first(),
            'hideMenu' => true,
            'history' => $this->getUserHistory(),
            'popular' => $popular
        ]);
    }

    public function privacyPolicy(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 1)->first(),
            'gap' => 0
        ]);
    }
    public function terms(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 2)->first(),
            'gap' => 0
        ]);
    }
    public function cookies(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 3)->first(),
            'gap' => 0
        ]);
    }

    public function aboutUs(): View{
        return view('public-part.app.pages.pages.page', [
            'history' => $this->getUserHistory(),
            'page' => Page::where('id', '=', 4)->first(),
            'gap' => 0
        ]);
    }

    /**
     * Page for testing effects
     *
     * @param $type
     * @return View
     */
    public function effects($type): View{
        return view('public-part.app.pages.pages.effects', [
            'history' => $this->getUserHistory(),
            'type' => $type
        ]);
    }

}
