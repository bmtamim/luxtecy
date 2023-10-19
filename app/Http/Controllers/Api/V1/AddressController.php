<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Api\V1\AddressUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'user_token' => ['required', 'string', 'exists:user_sessions,token']
        ]);

        $userToken = cleanUp($request->input('user_token'));
        $address   = Address::query()->where('user_token', $userToken)->first();

        return jsonResponseFormat(true, $address);
    }

    public function store(AddressRequest $request, AddressUpdateAction $action): JsonResponse
    {
        return $action($request);
    }
}
