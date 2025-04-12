<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Other\FAQ;
use App\Models\Other\Page;
use App\Models\User;
use App\Traits\Http\HttpTrait;
use App\Traits\Http\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SinglePagesController extends Controller{
    use ResponseTrait;

    protected string $_path = 'admin.app.other.single-pages.';

    public function index(): View{
        $pages = Page::where('id', '>', 0);
        $pages = Filters::filter($pages);
        $filters = [ 'title' => __('Naslov')];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'pages' => $pages
        ]);
    }

    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'page' => Page::where('id', '=', $id)->first()
        ]);
    }

    public function update(Request $request): JsonResponse{
        try{
            Page::where('id', '=', $request->id)->update(['title' => $request->title, 'description' => $request->description]);

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.other.single-pages.edit', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
