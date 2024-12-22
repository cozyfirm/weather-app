<?php

namespace App\Http\Controllers\PublicPart;

use App\Http\Controllers\Controller;
use App\Traits\API\ForecastTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller{
    use ForecastTrait;
    protected string $_path = 'public-part.app.pages.contact.';

    public function home(): View{
        return view($this->_path . 'home', [
            'history' => $this->getUserHistory()
        ]);
    }
}
