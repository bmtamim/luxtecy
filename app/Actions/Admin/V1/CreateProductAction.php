<?php

namespace App\Actions\Admin\V1;

use App\DTO\Admin\V1\ProductDTO;
use App\Http\Requests\Admin\V1\ProductRequest;
use App\Http\Resources\Admin\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateProductAction
{
    public function __invoke(ProductRequest $request): JsonResponse
    {
        $data = ProductDTO::create($request);
        try {
            DB::beginTransaction();
            $product = Product::create($data->toArray());

            $product->categories()->sync([$data->category_id]);
            DB::commit();

            return jsonResponseFormat(true, new ProductResource($product), __('Product Added!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 401);
        }
    }
}
