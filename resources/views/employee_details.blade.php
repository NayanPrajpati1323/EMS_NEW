@extends('layouts.app')

@section('content')


<div class="min-h-screen bg-gradient-to-br from-blue-200 via-teal-300 to-red-200 py-12 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Two-column layout -->
        <div class="flex flex-col md:flex-row gap-10 items-center justify-center">

            <!-- LEFT COLUMN: Image, Name, Status — Fully Centered -->
            <div class="w-full md:w-2/5 flex flex-col items-center text-center space-y-6">
                <!-- Profile Image -->
                @if($employee->image)
                <img
                    src="{{ asset('uploads/employees/' . $employee->image) }}"
                    alt="{{ $employee->first_name }} {{ $employee->last_name }}"
                    class="w-36 h-36 sm:w-44 sm:h-44 rounded-full object-cover border-4 border-white shadow-xl" />
                @else
                <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-lg">
                    <span class="text-gray-500 text-2xl font-bold">
                        {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                    </span>
                </div>
                @endif

                <!-- Full Name -->
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </h1>

                <!-- Status -->
                <div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $employee->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $employee->status ? 'Active Employee' : 'Inactive Employee' }}
                    </span>
                </div>
            </div>

            <!-- RIGHT COLUMN: Details — Fully Centered -->
            <div class="w-full md:w-3/5">
                <div class="bg-white/30 backdrop-blur-sm rounded-2xl shadow-lg p-6 sm:p-8 border border-white/30">
                    <div class="space-y-5 ">
                        <!-- Each detail as a centered block -->
                        <div>
                            <div class="text-gray-600 font-medium text-sm">Employee ID: {{ $employee->id }}</div>
                        </div>
                        <div>
                            <div class="text-gray-600 font-medium text-sm">First Name: {{ $employee->first_name }}</div>
                        </div>
                        <div>
                            <div class="text-gray-600 font-medium text-sm">Last Name: {{ $employee->last_name }}</div>
                        </div>
                        <div>
                            <div class="text-gray-600 font-medium text-sm">Email: {{ $employee->email }}</div>
                        </div>

                        <div>
                            <div class="text-gray-600 font-medium text-sm">Phone: {{ $employee->phone }}</div>
                        </div>

                        <div>
                            <div class="text-gray-600 font-medium text-sm">Address: {{ $employee->address }}</div>
                        </div>

                        <div>
                            <div class="text-gray-600 font-medium text-sm">Gender: {{ $employee->gender }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button - Centered -->
        <div class="mt-10 text-center">
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center px-5 py-2.5 bg-white/80 hover:bg-gray-700 hover:text-white text-teal-700 font-medium rounded-lg shadow transition duration-200 border border-teal-200 hover:shadow-md">
                ← Back to Employee List
            </a>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center text-gray-600 text-sm">
            &copy; {{ date('Y') }} Employee Management System. All rights reserved.
        </div>
    </div>
</div>
@endsection