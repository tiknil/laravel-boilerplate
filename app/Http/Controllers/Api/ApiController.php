<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\ErrorResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

abstract class ApiController extends Controller
{
    public function validateApiRequest(Request $request, array $rules): array
    {
        try {
            return $request->validate($rules);
        } catch (ValidationException $exception) {
            ErrorResponse::invalidRequest(
                'The request either misses some requested parameters or contains invalid ones',
                $exception->errors()
            )->send();

            exit();
        }
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
