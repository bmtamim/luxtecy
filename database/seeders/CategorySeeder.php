<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Services\FileUploadService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image      = new File(public_path('assets/img/300x300.svg'));
        $categories = [
            [
                'name'      => '汤底',
                'slug'      => 'soup-base',
                'thumbnail' => FileUploadService::uploadFile($image)
            ],
            [
                'name'      => '肉片',
                'slug'      => 'meatslice',
                'thumbnail' => FileUploadService::uploadFile($image)
            ],
            [
                'name'      => '海鲜',
                'slug'      => 'seafood',
                'thumbnail' => FileUploadService::uploadFile($image)
            ],
            [
                'name'      => '丸/滑类',
                'slug'      => 'balls',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '经典火锅菜',
                'slug'      => 'classic',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '蔬菜类',
                'slug'      => 'vege',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '面类',
                'slug'      => 'noodles',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '蘸料',
                'slug'      => 'sauces',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '饮料',
                'slug'      => 'beverage',
                'thumbnail' => FileUploadService::uploadFile($image)
            ]
        ];

        Category::query()->upsert($categories, ['slug'], ['name', 'thumbnail']);
    }
}
