<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        //Filter Data
        $search      = $request->filled('search') ? cleanUp($request->input('search')) : null;
        $category_id = $request->filled('category_id') ? cleanUp($request->input('category_id')) : null;

        $query = Product::query();

        //Do search
        if ($search) {
            $query->where(function ($searchQuery) use ($search) {
                return $searchQuery->where('title', 'LIKE', '%'.$search.'%')
                                   ->orWhere('title_cn', 'LIKE', '%'.$search.'%')
                                   ->orWhere('slug', 'LIKE', '%'.$search.'%');
            });
        }

        //Category
        if ($category_id) {
            $query->whereHas('categories', function ($categoryQuery) use ($category_id) {
                $categoryQuery->where('categories.id', $category_id);
            });
        }

        $products = $query->where('stock', '>', 0)
                          ->latest()
                          ->paginate(20);

        return jsonResponseFormat(true,
            ProductResource::collection($products)->response()->getData(true)
        );
    }
}
