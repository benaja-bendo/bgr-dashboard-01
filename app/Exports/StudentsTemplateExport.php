<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() : \Illuminate\Support\Collection
    {
        return collect([]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'last_name',
            'first_name',
            'gender',
            'birth_date',
            'email',
        ];
    }
}
