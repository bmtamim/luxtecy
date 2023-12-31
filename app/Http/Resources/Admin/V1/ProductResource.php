<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'title_cn'    => $this->title_cn,
            'slug'        => $this->slug,
            'price'       => $this->regular_price,
            'stock'       => $this->stock,
            'description' => $this->description,
            'label'       => $this->label,
            'thumbnail'   => asset_url($this->thumbnail),
            'category'    => $this->whenLoaded('categories', function () {
                return new CategoryResource($this->categories->first());
            }),
            'created_at'  => $this->created_at?->format(config('app.date_format_human')),
        ];
    }
}
