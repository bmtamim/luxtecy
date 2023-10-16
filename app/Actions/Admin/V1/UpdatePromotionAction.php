<?php

namespace App\Actions\Admin\V1;

use App\DTO\Admin\V1\PromotionDTO;
use App\Http\Requests\Admin\V1\PromotionRequest;
use App\Http\Resources\Admin\V1\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;

class UpdatePromotionAction
{
    public function __invoke(PromotionRequest $request, Promotion $promotion): JsonResponse
    {
        $data = PromotionDTO::create($request);
        try {

            $promotion->update($data->toArray());

            return jsonResponseFormat(true, new PromotionResource($promotion), __('Promotion Updated!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
