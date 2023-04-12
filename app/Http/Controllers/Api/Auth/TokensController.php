<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\Http\Responses\Api\ApiError;
use App\Http\Responses\Api\ErrorResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class TokensController extends ApiController
{
    public function login(Request $request): UserResource|JsonResponse
    {
        $params = $this->validateApiRequest($request, [
            'email' => 'required|string',
            'password' => 'required|string',
            'device_id' => 'required|string',
        ]);

        $user = User::where('email', $params['email'])->first();

        if (empty($user)) {
            return ErrorResponse::json(401, ApiError::InvalidCredentials);
        }

        if (!Hash::check($params['password'], $user->password)) {
            return ErrorResponse::json(401, ApiError::InvalidCredentials);
        }

        $deviceId = $params['device_id'];

        $this->revokeDeviceTokens($user, $deviceId);

        $auth = AuthTokens::forUser($user, $deviceId);

        return (new UserResource($user))->additional([
            'meta' => $auth->toMetaArray(),
        ]);
    }

    public function refresh(Request $request): UserResource
    {
        // Se arrivo qua, il token è già stato verificato
        $deviceId = $this->revokeRequestToken($request);

        $user = $request->user();

        $auth = AuthTokens::forUser($user, $deviceId);

        return (new UserResource($user))->additional([
            'meta' => $auth->toMetaArray(),
        ]);
    }

    public function logout(Request $request): Response
    {
        $this->revokeRequestToken($request);

        return response()->noContent();
    }

    private function revokeRequestToken(Request $request): string
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        $this->revokeDeviceTokens($user, $token->name);

        return $token->name;
    }

    private function revokeDeviceTokens(User $user, string $deviceId): void
    {
        $user->tokens()->where('name', $deviceId)->delete();
    }
}
