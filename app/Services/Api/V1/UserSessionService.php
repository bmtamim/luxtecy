<?php

namespace App\Services\Api\V1;

use App\Http\Controllers\Api\V1\UserTokenController;
use App\Models\UserSession;
use Illuminate\Support\Str;

class UserSessionService
{
    public static function generateToken(): string
    {
        $string    = Str::random(30);
        $unique_id = uniqid();
        $token     = Str::substrReplace($string, $unique_id, 10, 0);

        $exist = UserSession::query()->where('token', $token)->first();
        if ($exist) {
            self::generateToken();
        }

        return $token;
    }
}
