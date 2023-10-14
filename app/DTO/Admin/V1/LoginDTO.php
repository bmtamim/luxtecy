<?php

namespace App\DTO\Admin\V1;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Admin\V1\LoginRequest;

class LoginDTO extends DataTransferObject
{
    public string $email;
    public string|int $password;

    public static function create(LoginRequest $request): LoginDTO
    {
        return new self([
            'email'    => cleanUp($request->input('email')),
            'password' => cleanUp($request->input('password')),
        ]);
    }

    public function toArray(): array
    {
        return [
            'email'    => $this->email,
            'password' => $this->password
        ];
    }
}
