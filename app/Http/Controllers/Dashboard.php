<?php

namespace App\Http\Controllers;

use App\Models\EmployeesModel;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalEmployees = EmployeesModel::count();
        $activeEmployees = EmployeesModel::where('status', 1)->count();
        $inactiveEmployees = EmployeesModel::where('status', 0)->count();
        $males = EmployeesModel::where('gender', 'Male')->count();
        $females = EmployeesModel::where('gender', 'Female')->count();

        return view('dashboard', compact('totalEmployees', 'activeEmployees', 'inactiveEmployees', 'males', 'females'));
    }

}
