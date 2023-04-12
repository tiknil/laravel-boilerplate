<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
