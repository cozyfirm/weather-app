<?php

namespace App\Http\Middleware;

use App\Models\Users\History\SearchHistory;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class forecast
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{
        $history = SearchHistory::where('ip_addr', '=', request()->ip())
            ->where('updated_at', '>=', Carbon::now()->subHours(12)->format('Y-m-d H:00:00'))
            ->orderBy('updated_at', 'DESC')
            ->take(6)
            ->get();

        /* ToDo -- Check this one for last 12 hours */
        View::composer('history', $history);
        return $next($request);
    }
}
