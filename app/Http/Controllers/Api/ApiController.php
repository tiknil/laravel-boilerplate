<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    public function validateApiRequest(Request $request, array $rules): array
    {
        return $request->validate($rules);
    }

    /**
     * Data una query da paginare:
     * - Vengono calcolati i dati da ritornare nel meta della risposta API
     * - Vengono aggiunte le dovute limitazioni alla query di partenza
     *
     * Il numero di pagina viene preso direttamente dalla request, e la prima pagina corrisponde al numero 0
     */
    public function paginate(Builder &$query, int $pageSize = 50): array
    {
        $page = intval(request('page', 0));

        $total = $query->clone()->count();

        $max = $total / $pageSize;

        if (is_float($max)) {
            $max = intval(floor($max));
        } else {
            $max = max($max - 1, 0);
        }

        $query->limit($pageSize)
            ->offset($pageSize * $page);

        return [
            'total' => $total,
            'current' => $page,
            'max' => $max,
            'page_size' => $pageSize,
        ];
    }
}
