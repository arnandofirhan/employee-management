<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Employee extends Model
{   
    public function getGenderLabel($id)
    {
        $genders = [
            1 => 'Laki-laki',
            2 => 'Perempuan',
        ];

        return $genders[$id] ?? 'Tidak Diketahui';
    }
    protected $table = 'entities';

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class, 'employee_status_id', 'id');
    }
}
