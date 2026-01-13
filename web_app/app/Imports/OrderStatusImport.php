<?php

namespace App\Imports;

use App\Models\OrderStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrderStatusImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['name'])) {
            return null;
        }

        $status = OrderStatus::where('name', $row['name'])->first();

        if ($status) {
            $status->update([
                'name' => $row['name'],
            ]);
            return null;
        }

        return new OrderStatus([
            'name' => $row['name'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
