<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

use Illuminate\Contracts\Encryption\DecryptException;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $employees;
    protected $index = 0;
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
        $this->index++;
        
        return [

            $this->index,
            $employee->full_name,
            $employee->department->full_name,
            $employee->job_placement,
            $employee->employeeStatus->name,
            $employee->birth_place . ', ' . 
            ($employee->birth_date ? Carbon::parse($employee->birth_date)->format('d F Y') : 'N/A'),
            $employee->getGenderLabel($employee->gender_category),
            $identityNumber = "\t" . $employee->identity_number,
            $employee->phone,
            ($employee->join_date ? Carbon::parse($employee->join_date)->format('d F Y') : 'N/A')

        ];
    }

    /**
     * @return array
     */

    public function styles(Worksheet $entities)
    {
        $entities->getStyle($entities->calculateWorksheetDimension())
              ->getAlignment()
              ->setHorizontal('center');

        // Set auto width untuk semua kolom
        foreach ($entities->getColumnIterator() as $column) {
            $entities->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    
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