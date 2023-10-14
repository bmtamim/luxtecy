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
                'slug'      => 'category-1',
                'thumbnail' => FileUploadService::uploadFile($image)
            ],
            [
                'name'      => '肉片',
                'slug'      => 'category-2',
                'thumbnail' => FileUploadService::uploadFile($image)
            ],
            [
                'name'      => '海鲜',
                'slug'      => 'category-3',
                'thumbnail' => FileUploadService::uploadFile($image)
            ],
            [
                'name'      => '丸/滑类',
                'slug'      => 'category-4',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '经典火锅菜',
                'slug'      => 'category-5',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '蔬菜类',
                'slug'      => 'category-6',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '面类',
                'slug'      => 'category-7',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '蘸料',
                'slug'      => 'category-8',
                'thumbnail' => FileUploadService::uploadFile($image)
            ], [
                'name'      => '饮料',
                'slug'      => 'category-9',
                'thumbnail' => FileUploadService::uploadFile($image)
            ]
        ];

        Category::query()->upsert($categories, ['slug'], ['name', 'thumbnail']);
    }
}
