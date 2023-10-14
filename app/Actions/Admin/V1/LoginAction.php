<?php

namespace App\Actions\Admin\V1;

use App\DTO\Admin\V1\LoginDTO;
use App\Http\Requests\Admin\V1\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $loginData = LoginDTO::create($request);
        try {
            $user = User::query()->where('email', $loginData->email)->first();
            if ( ! $user) {
                return jsonResponseFormat(false, null, trans('auth.failed'), 401);
            }
            //Check Password
            if ( ! Hash::check($loginData->password, $user->password)) {
                return jsonResponseFormat(false, null, trans('auth.failed'), 401);
            }

            $token = $user->createToken('admin')->plainTextToken;

            return jsonResponseFormat(true, [
                'user'  => $user,
                'token' => $token
            ]);

        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, trans('auth.failed'), 401);
        }
    }
}
