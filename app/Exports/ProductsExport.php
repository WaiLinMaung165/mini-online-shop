<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Override;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithDrawings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['category','inventory'])->get();
    }

    public function headings(): array{
        return[
            'Category',
            'Name',
            'Image',
            'Gender',
            'Price',
            'Stock Quantity',
            'Description',
        ];
    }

    public function map($product): array{
        return [
            $product->category->name ?? 'Uncategorized',
            $product->name,
            '',
            $product->gender,
            $product->price,
            $product->inventory->stock_quantity?? 0,
            $product->description,
        ];
    }

    #[Override]
    public function drawings()
    {
        $products = Product::all();
        $drawings = [];

        $rowNumber = 2;
        foreach ($products as $product){
            if ($product->image && Storage::disk('public')->exists($product->image)){
                $drawing = new Drawing();
                $drawing->setName('Product Image');
                $drawing->setDescription('Product Image');
                $drawing->setPath(storage_path('app/public/' . $product->image));
                $drawing->setHeight(40);
                $drawing->setCoordinates('C' . $rowNumber);
                $drawings[] = $drawing;
            }
            $rowNumber++;
        }
        return $drawings;
    }
}
