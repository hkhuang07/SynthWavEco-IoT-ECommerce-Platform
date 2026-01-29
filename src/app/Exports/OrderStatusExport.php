<?php

namespace App\Exports;

use App\Models\OrderStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderStatusExport implements FromCollection, WithCustomStartCell, WithHeadings, WithMapping
{
    public function headings():array
    {
        return [
            'name',
        ];
    }

    public function map($statues): array
    {
        return [
            $statues->name,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function collection()
    {
        return OrderStatus::all();
    }
}
