<?php

namespace App\Http\Controllers\Admin\V1;

use App\Actions\Admin\V1\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $action($request);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
