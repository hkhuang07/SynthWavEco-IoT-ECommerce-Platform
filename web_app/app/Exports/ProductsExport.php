<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithCustomStartCell, WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            // Product
            'category_id',
            'manufacturer_id',
            'name',
            'slug',
            'price',
            'stock_quantity',
            'description',
            // Product Details
            'memory',
            'cpu',
            'graphic',
            'power_specs',
            // Product Image
            'image_url',
        ];
    }

    public function map($product): array
    {
        // Lấy avatar image
        $avatarImage = $product->images->where('is_avatar', true)->first();
        
        return [
            // Product
            $product->category_id,
            $product->manufacturer_id,
            $product->name,
            $product->slug,
            $product->price,
            $product->stock_quantity,
            $product->description,
            // Product Details
            $product->details->memory ?? null,
            $product->details->cpu ?? null,
            $product->details->graphic ?? null,
            $product->details->power_specs ?? null,
            // Product Image
            $avatarImage->url ?? null,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }
    
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Load relationships
        return Product::with(['details', 'images'])->get();
    }
}