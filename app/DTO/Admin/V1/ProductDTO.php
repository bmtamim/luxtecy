<?php

namespace App\DTO\Admin\V1;

use App\Abstracts\DataTransferObject;
use App\Http\Requests\Admin\V1\ProductRequest;
use App\Services\FileUploadService;


class ProductDTO extends DataTransferObject
{
    public string $title;
    public string $title_cn;
    public float $regular_price;
    public float $stock;
    public string $description;
    public string $thumbnail;
    public int $category_id;
    public ?string $label;

    public static function create(ProductRequest $request, $product = null): ProductDTO
    {
        $oldImageName = $product?->thumbnail ?: null;
        $imageName    = $oldImageName;
        //Upload Image When File Is Available
        if ($request->hasFile('thumbnail')) {
            $imageName = FileUploadService::uploadFile($request->file('thumbnail'), $oldImageName);
        }

        return new self([
            'title'         => cleanUp($request->input('title_en')),
            'title_cn'      => cleanUp($request->input('title_cn')),
            'regular_price' => (float) $request->input('price'),
            'stock'         => (float) $request->input('stock'),
            'description'   => cleanUp($request->input('description')),
            'category_id'   => (int) $request->input('category_id'),
            'label'         => cleanUp($request->input('label')),
            'thumbnail'     => $imageName,
        ]);
    }

    public function toArray(): array
    {
        return [
            'title'         => $this->title,
            'title_cn'      => $this->title_cn,
            'regular_price' => $this->regular_price,
            'stock'         => $this->stock,
            'description'   => $this->description,
            'thumbnail'     => $this->thumbnail,
            'label'         => $this->label,
        ];
    }
}
