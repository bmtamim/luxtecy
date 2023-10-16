<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserSession;
use App\Services\Api\V1\UserSessionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserTokenController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $unique_token = UserSessionService::generateToken();
            $session      = UserSession::query()->create([
                'token' => $unique_token
            ]);

            return jsonResponseFormat(true, [
                'user_token' => $session->token
            ]);
        } catch (Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
