<?php

namespace App\Http\Controllers\Admin\V1;

use App\Actions\Admin\V1\UpdatePromotionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\PromotionRequest;
use App\Http\Resources\Admin\V1\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::query()->get();

        return jsonResponseFormat(true, PromotionResource::collection($promotions));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromotionRequest $request, Promotion $promotion, UpdatePromotionAction $action): JsonResponse
    {
        return $action($request, $promotion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
