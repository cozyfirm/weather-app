<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Users\History\SearchHistory;
use App\Traits\API\ForecastTrait;
use App\Traits\Common\CommonTrait;
use App\Traits\Common\LogTrait;
use App\Traits\Http\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HistoryController extends Controller{
    use ResponseTrait, LogTrait, CommonTrait, ForecastTrait;

    protected int $_history_samples = 6;

    /**
     * Get user search history by ip addr
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchHistory(Request $request): JsonResponse{
        try{
            return $this->apiResponse('0000', __('Success'), [
                SearchHistory::where('ip_addr', '=', request()->ip())
                    ->where('updated_at', '>=', Carbon::now()->subHours(8)->format('Y-m-d H:00:00'))
                    ->orderBy('updated_at', 'DESC')
                    ->take($this->_history_samples)
                    ->with('cityRel.twelveHoursCurrentRel:id,city_key,icon,temperature')
                    ->with('cityRel:id,key,name,slug,country')
                    ->get()->toArray()
            ]);
        }catch (\Exception $e){
            $this->write('HistoryController::searchHistory()', $e->getCode(), $e->getMessage(), $request);
            return $this->apiResponse('3200', __('Greška prilikom obrade zahtjeva. Molimo kotantktirajte administratora!'));
        }
    }
}
