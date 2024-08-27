<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function export()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }
}
