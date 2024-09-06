<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Crypt;

class EmployeeController extends Controller
{
    public function export()
    {
        return Excel::download(new EmployeesExport, 'Daftar SPJMI 2024.xlsx');
    }
}
