<?php

namespace App\DTO\Api\V1;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Api\V1\AddressRequest;

class AddressDTO extends DataTransferObject
{
    public string $user_token;
    public ?string $name;
    public ?string $phone;
    public ?string $address;
    public ?string $address_details;
    public ?string $latitude;
    public ?string $longitude;
    public ?string $postal_code;

    public static function create(AddressRequest $request): AddressDTO
    {
        return new self([
            'user_token'      => cleanUp($request->input('user_token')),
            'name'            => cleanUp($request->input('name')),
            'phone'           => cleanUp($request->input('phone')),
            'address'         => cleanUp($request->input('address')),
            'address_details' => cleanUp($request->input('address_details')),
            'latitude'        => cleanUp($request->input('latitude')),
            'longitude'       => cleanUp($request->input('longitude')),
            'postal_code'     => cleanUp($request->input('postal_code')),
        ]);
    }

    public function toArray(): array
    {
        return [
            //'user_token'      => $this->user_token,
            'name'            => $this->name,
            'phone'           => $this->phone,
            'address'         => $this->address,
            'address_details' => $this->address_details,
            'latitude'        => $this->latitude,
            'longitude'       => $this->longitude,
            'postal_code'     => $this->postal_code,
        ];
    }
}
