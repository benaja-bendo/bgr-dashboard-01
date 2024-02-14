<?php

namespace App\Exports;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection, WithHeadings
{
    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return User::role(RolesEnum::student->value)
            ->select('last_name', 'first_name','gender','birth_date','email') // 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at
            ->orderBy('created_at', 'desc')->get();
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
