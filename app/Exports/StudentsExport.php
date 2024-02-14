<?php

namespace App\Exports;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return User::role(RolesEnum::student->value)
            ->select('last_name', 'email')
            ->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
        ];
    }
}
