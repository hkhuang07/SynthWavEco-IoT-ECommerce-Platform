<?php

namespace App\Exports;

use App\Models\Manufacturer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class ManufacturesExport implements FromCollection, WithCustomStartCell, WithHeadings, WithMapping
{
    
    public function headings(): array
    {
        return [
            'name',
            'slug',
            'address',
            'description',
            'contact_phone',
            'contact_email',
            'logo',
        ];
    }

    public function map($manufacturer): array
    {
        return [
            $manufacturer->name,
            $manufacturer->slug,
            $manufacturer->address,
            $manufacturer->description,
            $manufacturer->contact_phone,
            $manufacturer->contact_email,
            $manufacturer->logo,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function collection()
    {
        return Manufacturer::all();
    }
}
