<?php

namespace App\Http\Controllers\Admin\V1;

use App\Actions\Admin\V1\CreateProductAction;
use App\Actions\Admin\V1\DeleteProductAction;
use App\Actions\Admin\V1\ProductUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\ProductRequest;
use App\Http\Resources\Admin\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $products = Product::query()->with(['categories'])->latest()->paginate(10);

        return jsonResponseFormat(true,
            ProductResource::collection($products)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request, CreateProductAction $action): JsonResponse
    {
        return $action($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::query()->with(['categories'])->findOrFail($id);

        return jsonResponseFormat(true, new ProductResource($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product, ProductUpdateAction $action): JsonResponse
    {
        return $action($request, $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, DeleteProductAction $action): JsonResponse
    {
        return $action($product);
    }
}
