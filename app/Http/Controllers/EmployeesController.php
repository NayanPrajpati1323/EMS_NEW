<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeesModel;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = EmployeesModel::orderBy('id', 'desc');

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(10); // 10 items per page

        return view('employees', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = $employee->image;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($imageName && file_exists(public_path('uploads/employees/' . $imageName))) {
                unlink(public_path('uploads/employees/' . $imageName));
            }

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

    public function employeesDetails($id)
    {
        $employee = EmployeesModel::findOrFail($id);
        return view('employee_details', compact('employee'));
    }

    public function destroy($id)
    {
        try {
            $employee = EmployeesModel::findOrFail($id);

            if ($employee->image && file_exists(public_path('uploads/employees/' . $employee->image))) {
                unlink(public_path('uploads/employees/' . $employee->image));
            }

            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting employee: ' . $e->getMessage()
            ], 500);
        }
    }
}