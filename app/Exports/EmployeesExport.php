<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Employee::all();
    }

    /**
     * @var Employee $employee
     */
    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->full_name,
            $employee->department_id,
            $employee->job_placement,
            $employee->employee_status,
            $employee->birth_place . ', ' . $employee->birth_date->format('d F Y'),
            $employee->gender_category,
            $employee->full_name1,
            $employee->phone,
            $employee->employee_status_id->format('d F Y'),
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.',
            'Nama Lengkap',
            'Departement',
            'Plant',
            'Status Karyawan',
            'Tempat, Tanggal Lahir',
            'Jenis Kelamin',
            'No. KTP',
            'No. Telepon',
            'Tanggal Gabung'
        ];
    }
}