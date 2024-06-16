<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StudentImport implements WithValidation, WithHeadings, WithHeadingRow, SkipsEmptyRows,WithMappedCells
{
    use Importable;

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

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'nullable',
            'email' => 'required|email|unique:users,email',
        ];
    }

    /**
     * @return array
     */
    public function mapping(): array
    {
        return [
            'last_name' => 'A',
            'first_name' => 'B',
            'gender' => 'C',
            'birth_date' => 'D',
            'email' => 'E',
        ];
    }
}
