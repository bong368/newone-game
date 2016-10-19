<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('paging', function (AbstractPaginator $value) {
            if ($value instanceof LengthAwarePaginator) {
                return Response::json([
                    'data' => $value->items(),
                    'paging' => [
                        'total' => $value->total(),
                        'per_page' => (int)$value->perPage(),
                        'current_page' => $value->currentPage(),
                        'last_page' => $value->lastPage(),
                        'has_next_page' => ($value->lastPage() > $value->currentPage()),
                        'has_prev_page' => ($value->currentPage() > 1),
                    ]
                ]);
            } else if ($value instanceof Paginator) {
                return Response::json([
                    'data' => $value->items(),
                    'paging' => [
                        'per_page' => (int)$value->perPage(),
                        'current_page' => $value->currentPage(),
                        'has_next_page' => $value->hasMorePages(),
                        'has_prev_page' => ($value->currentPage() > 1),
                    ]
                ]);
            } else {
                throw new \ErrorException('Argument 1 passed to closure must be an instance of LengthAwarePaginator or Paginator');
            }
        });
    }
}
