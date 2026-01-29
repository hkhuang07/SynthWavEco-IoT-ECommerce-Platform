<?php

namespace App\Imports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RolesImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        if (empty($row['name'])) {
            return null;
        }

        $role = Role::where('name', $row['name'])->first();

        if ($role) {
            $role->update([
                'name' => $row['name'],
                'description' => $row['description'],
            ]);
            return null;
        }

        return new Role([
            'name' => $row['name'],
            'description' => $row['description'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
