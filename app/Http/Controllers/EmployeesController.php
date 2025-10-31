<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeesModel;


class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $employees = EmployeesModel::all();
        $employees = \App\Models\EmployeesModel::orderBy('id', 'desc')->paginate(10);

        //search functinality
        $search = $request->input('search');
        $employees = EmployeesModel::when($search, function ($query, $search) {
            return $query->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->paginate(10);

        return view('employees', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employees'), $imageName);
        }

        EmployeesModel::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'image' => $imageName,
            'status' => $request->status ? 1 : 0,
        ]);

        return back()->with('success', 'Employee added successfully!');
    }

    public function update(Request $request, $id)
    {
        $employee = EmployeesModel::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $imageName = $employee->image;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employees'), $imageName);
        }

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'image' => $imageName,
            'status' => $request->status ? 1 : 0,
        ]);

        return back()->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = EmployeesModel::findOrFail($id);

        if ($employee->image && file_exists(public_path('uploads/employees/' . $employee->image))) {
            unlink(public_path('uploads/employees/' . $employee->image));
        }

        $employee->delete();
        return back()->with('success', 'Employee deleted successfully!');
    }
}
