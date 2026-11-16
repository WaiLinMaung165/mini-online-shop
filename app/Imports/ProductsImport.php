<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);
        $category = Category::firstOrCreate(
            ['name' => $row['category'] ?? 'Uncategorized'],
            ['slug' => Str::slug($row['category'] ?? 'Uncategorized')]
        );

        $imagePath = null;
        // $imagePath = $row['image'] ?? null;
        if (!empty($row['image'])){
            try{
                $imageUrl = trim($row['image']);
                $contents = Http::timeout(10)->get($imageUrl)->body();

                $filename = 'products/' . Str::slug($row['name']) . '-' . time() . '.jpg';

                Storage::disk('public')->put($filename,$contents);
                $imagePath = $filename;
            } catch (\Exception $e) {
                $imagePath = null;
            }
        }

        $product = Product::create([
            'category_id' => $category->id,
            'name'        => $row['name'],
            'slug'        => Str::slug($row['name']),
            'image'       => $imagePath,
            'gender'      => strtolower($row['gender'] ?? 'unisex'),
            'price'       => $row['price'] ?? 0,
            'description' => $row['description'] ?? null,
        ]);

        Inventory::create([
            'product_id'     => $product->id,
            'stock_quantity' => $row['stock_quantity'] ?? 0,
        ]);

        return $product;
    }
}
