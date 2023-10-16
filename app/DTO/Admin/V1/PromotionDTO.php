<?php

namespace App\DTO\Admin\V1;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Admin\V1\PromotionRequest;

class PromotionDTO extends DataTransferObject
{
    public bool $is_active;

    public static function create(PromotionRequest $request): PromotionDTO
    {
        return new self([
            'is_active' => $request->filled('is_active')
        ]);
    }

    public function toArray(): array
    {
        return [
            'is_active' => $this->is_active
        ];
    }
}
