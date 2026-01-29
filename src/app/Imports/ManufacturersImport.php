<?php

namespace App\Imports;

use App\Models\Manufacturer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ManufacturersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Bỏ qua nếu không có name
        if (empty($row['name'])) {
            return null;
        }

        // Check tồn tại -> update, không thì create
        $manufacturer = Manufacturer::where('slug', $row['slug'])->first();

        if ($manufacturer) {
            $manufacturer->update([
                'name' => $row['name'],
                'address' => $row['address'] ?? null,
                'description' => $row['description'] ?? null,
                'contact_phone' => $row['contact_phone'] ?? null,
                'contact_email' => $row['contact_email'] ?? null,
                'logo' => $row['logo'] ?? $manufacturer->logo,
            ]);
            return null; // Đã update, không cần return model mới
        }

        return new Manufacturer([
            'name' => $row['name'],
            'slug' => $row['slug'],
            'address' => $row['address'] ?? null,
            'description' => $row['description'] ?? null,
            'contact_phone' => $row['contact_phone'] ?? null,
            'contact_email' => $row['contact_email'] ?? null,
            'logo' => $row['logo'] ?? null,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}