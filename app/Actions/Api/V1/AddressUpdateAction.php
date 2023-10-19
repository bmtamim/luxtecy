<?php

namespace App\Actions\Api\V1;

use App\DTO\Api\V1\AddressDTO;
use App\Http\Requests\Api\V1\AddressRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;

class AddressUpdateAction
{
    public function __invoke(AddressRequest $request): JsonResponse
    {
        $data = AddressDTO::create($request);
        try {

            Address::query()->updateOrCreate([
                'user_token' => $data->user_token
            ], $data->toArray());

            return jsonResponseFormat(true, null, __('Address updated'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
