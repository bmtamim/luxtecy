<?php

namespace App\Http\Controllers\Admin\V1;

use App\Actions\Admin\V1\UpdatePostalCodeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\PostalCodeRequest;
use App\Services\Api\V1\PostalCodeService;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function getPostalCode(): JsonResponse
    {
        return jsonResponseFormat(true, PostalCodeService::postalCodes());
    }

    public function savePostalCode(PostalCodeRequest $request, UpdatePostalCodeAction $action): JsonResponse
    {
        return $action($request);
    }
}
