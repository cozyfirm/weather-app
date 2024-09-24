<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Core\Filters;
use App\Models\Other\FAQ;
use App\Traits\Common\FileTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FAQsController extends Controller{
    use UserBaseTrait, ResponseTrait, FileTrait;
    protected string $_path = 'admin.app.other.faq.';

    public function faqIndex  (): View{
        $faqs = FAQ::where('id', '>', 0);
        $faqs = Filters::filter($faqs);
        $filters = [ 'title' => __('Naziv'), 'what' => __('Sekcija') ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'faqs' => $faqs
        ]);
    }
    public function faqCreate(): View{
        return view($this->_path . 'create', [
            'create' => true,
            'other' => [0 => 'Something', 1 => "Something else"]
        ]);
    }
    public function faqSave(Request $request): JsonResponse{
        try{
            $faq = FAQ::create($request->all());

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.other.faq.edit', ['id' => $faq->id]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
    public function faqEdit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'other' => [0 => 'Something', 1 => "Something else"],
            'faq' => FAQ::where('id', '=', $id)->first()
        ]);
    }
    public function faqUpdate(Request $request): JsonResponse{
        try{
            FAQ::where('id', '=', $request->id)->update($request->except(['id', 'undefined', 'files']));

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.other.faq.edit', ['id' => $request->id]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function faqDelete($id): RedirectResponse{
        FAQ::where('id', '=', $id)->delete();

        return redirect()->route('system.admin.other.faq')->with('success', __('Uspješno obrisano!'));
    }
}
