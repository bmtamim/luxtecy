<?php

namespace App\DTO\Admin\V1;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Admin\V1\OrderRequest;

class OrderDTO extends DataTransferObject
{
    public string $status;

    public static function create(OrderRequest $request): OrderDTO
    {
        return new self([
            'status' => cleanUp($request->input('status'))
        ]);
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status
        ];
    }
}
