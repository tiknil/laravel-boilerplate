<?php

namespace App\Http\Responses\Api;

enum ApiError: int
{
    // Generics
    case InvalidRequest = 1;
    case ServerError = 2;
    case UnknownError = 3;
    case InvalidMethod = 4;
    case HttpNotFound = 5;
    case ResourceNotFound = 6;

    // Auth
    case InvalidCredentials = 10;
    case Unauthorized = 11;
    case Forbidden = 12;
}
