<?php

namespace App\Imports\Entities;

use App\Constants\GenderCategoryConstant;
use App\Models\Department;
use App\Models\EmployeeStatus;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EntityImport implements WithHeadingRow, WithValidation
{
    use Importable;

    public function prepareForValidation($data, $index)
    {
        $notes = [];
        $isValidated = true;

        $fullName = trim($data['full_name']);
        if (!$fullName) {
            $isValidated = false;
            $notes[] = "Nama lengkap harus diisi";
        }

        $genderCategory = null;
        $genderCategoryName = trim($data['gender_category_name']);
        if ($genderCategoryName) {
            switch ($genderCategoryName) {
                case 'LAKI-LAKI':
                    $genderCategory = GenderCategoryConstant::MALE;
                    break;
                case 'PEREMPUAN':
                    $genderCategory = GenderCategoryConstant::FEMALE;
                    break;
                default:
                    $isValidated = false;
                    $notes[] = "Format jenis kelamin sesuai";
                    break;
            }
        } else {
            $isValidated = false;
            $notes[] = "Jenis kelamin harus diisi";
        }

        $birthPlace = trim($data['birth_place']);
        if (!$birthPlace) {
            $isValidated = false;
            $notes[] = "Tempat lahir harus diisi";
        }

        $birthDate = trim($data['birth_date']);
        if ($birthDate) {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $birthDate)) {
                $isValidated = false;
                $notes[] = "Format tanggal lahir tidak sesuai";
            }
        } else {
            $isValidated = false;
            $notes[] = "Tanggal lahir harus diisi";
        }

        $identityNumber = trim($data['identity_number']);
        if ($identityNumber) {
            if (!preg_match("/^(1[1-9]|21|[37][1-6]|5[1-3]|6[1-5]|[89][12])\d{2}\d{2}([04][1-9]|[1256][0-9]|[37][01])(0[1-9]|1[0-2])\d{2}\d{4}$/", $identityNumber)) {
                $isValidated = false;
                $notes[] = "Format NIK tidak sesuai";
            }
        } else {
            $isValidated = false;
            $notes[] = "NIK harus diisi";
        }

        $identityFullAddress = trim($data['identity_full_address']);
        if (!$identityFullAddress) {
            $isValidated = false;
            $notes[] = "Alamat Lengkap KTP harus diisi";
        }

        $phone = trim($data['phone']) ?? null;

        $joinDate = trim($data['join_date']);
        if ($joinDate) {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $joinDate)) {
                $isValidated = false;
                $notes[] = "Format tanggal bergabung tidak sesuai";
            }
        } else {
            $isValidated = false;
            $notes[] = "Tanggal bergabung harus diisi";
        }

        $department = null;
        $departmentFullName = trim($data['department_full_name']);
        if ($departmentFullName) {
            $department = Department::query()
                ->where('full_name', $departmentFullName)
                ->first();
            if (!$department) {
                $isValidated = false;
                $notes[] = "Department tidak ditemukan";
            }
        } else {
            $isValidated = false;
            $notes[] = "Department harus diisi";
        }

        $jobPlacement = trim($data['job_placement']);
        if (!$jobPlacement) {
            $isValidated = false;
            $notes[] = "Lokasi penempatan kerja harus diisi";
        }

        $employeeStatus = null;
        $employeeStatusName = trim($data['employee_status_name']);
        if ($employeeStatusName) {
            $employeeStatus = EmployeeStatus::query()
                ->where('name', $employeeStatusName)
                ->first();
            if (!$employeeStatus) {
                $isValidated = false;
                $notes[] = "Status karyawan tidak ditemukan";
            }
        } else {
            $isValidated = false;
            $notes[] = "Status karyawan harus diisi";
        }

        $note = trim($data['note']) ?? null;

        return [
            'full_name' => $fullName,
            'gender_category' => $genderCategory ? $genderCategory : null,
            'gender_category_name' => $genderCategoryName,
            'birth_place' => $birthPlace ?? null,
            'birth_date' => $birthDate ?? null,

            'identity_number' => $identityNumber ?? null,
            'phone' => $phone ?? null,
            'identity_full_address' => $identityFullAddress ?? null,

            'join_date' => $joinDate ?? null,
            'department_id' => $department ? $department->id : null,
            'department_full_name' => $department ? $department->full_name : $departmentFullName,
            'job_placement' => $jobPlacement ?? null,
            'employee_status_id' => $employeeStatus ? $employeeStatus->id : null,
            'employee_status_name' => $employeeStatus ? $employeeStatus->name : $employeeStatusName,

            'note' => $note ?? null,
            'is_active' => true,

            'is_validated' => $isValidated,
            'notes' => $notes,
        ];
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function isEmptyWhen(array $row): bool
    {
        return !trim($row['full_name']);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required',
            'gender_category' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required',
            'identity_number' => 'required',
            'identity_full_address' => 'required',
            'phone' => 'nullable',
            'join_date' => 'required',
            'department_full_name' => 'required',
            'job_placement' => 'required',
            'employee_status_name' => 'required',
            'note' => 'nullable',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap harus diisi',
            'gender_category.required' => 'Telepon harus diisi',
            'birth_place.required' => 'Tempat lahir harus diisi',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'identity_number.required' => 'NIK harus diisi',
            'identity_full_address.required' => 'Alamat Lengkap KTP harus diisi',
            'join_date.required' => 'Tanggal bergabung harus diisi',
            'department_full_name.required' => 'Kategori project harus diisi',
            'job_placement.required' => 'Lokasi penempatan kerja harus diisi',
            'employee_status_name.required' => 'Status karyawan  harus diisi',
            'gender_category.required' => 'Janis kelamin harus diisi',
        ];
    }
}
