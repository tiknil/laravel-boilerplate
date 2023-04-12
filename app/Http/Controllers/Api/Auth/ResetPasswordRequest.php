<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordRequest extends ApiController
{
    public function resetRequest(Request $request): JsonResponse
    {
        $params = $this->validateApiRequest($request, [
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(['email' => $params['email']]);

        return new JsonResponse(['result' => $status === Password::RESET_LINK_SENT]);
    }
}
