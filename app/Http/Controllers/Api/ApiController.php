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
            return parent::validate($request, $rules);
        } catch (ValidationException $exception) {
            ErrorResponse::invalidRequest(
                'The request either misses some requested parameters or contains invalid ones',
                $exception->errors()
            )->send();

            exit();
        }
    }
}
