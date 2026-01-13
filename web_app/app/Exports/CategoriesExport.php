<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, WithCustomStartCell, WithHeadings, WithMapping
{
    
    public function headings(): array
    {
        return [
            'name',
            'slug',
            'parent_id',
            'description',
            'image',
        ];
    }

    public function map($category): array
    {
        return [
            $category->name,
            $category->slug,
            $category->parent_id,
            $category->description,
            $category->image,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }       

    public function collection()
    {
        return Category::all();
    }
}
