<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class RolesExport implements FromCollection, WithCustomStartCell, WithHeadings, WithMapping
{
    public function headings(): array
    {
        return [
            'name',
            'description',
        ];
    }

    public function map($role): array
    {
        return [
            $role->name,
            $role->description,
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function collection()
    {
        return Role::all();
    }
}
