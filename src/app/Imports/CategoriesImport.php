<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        if(empty($row['name'])) {
            return null;
        }

        $category = Category::where('slug', $row['slug'])->first();

        if ($category) {
            $category->update([
                'name' => $row['name'],
                'slug' => $row['slug'],
                'image' => $row['image'],
                'parent_id' => $row['parent_id'],
                'description' => $row['description'],
            ]);
            return null;
        }

        return new Category([
            'name' => $row['name'],
            'slug' => $row['slug'],
            'image' => $row['image'] ?? null,
            'parent_id' => $row['parent_id'] ?? null,
            'description' => $row['description'] ?? null,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
