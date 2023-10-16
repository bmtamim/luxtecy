<?php

namespace App\Actions\Admin\V1;

use App\Models\Product;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;

class DeleteProductAction
{
    public function __invoke(Product $product): JsonResponse
    {
        try {
            //Here is the image deletion process based on order item
            FileUploadService::deleteFile($product->thumbnail);
            //Delete The product
            $product->delete();

            return jsonResponseFormat(true, null, __('Product Deleted!'));
        } catch (\Exception $exception) {
            return jsonResponseFormat(false, null, $exception->getMessage(), 500);
        }
    }
}
