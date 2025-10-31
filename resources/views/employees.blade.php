@extends('layouts.app')

@section('content')
<div>

    <div class="flex justify-between items-center mb-4">
        <div>
            <form method="GET" action="{{ route('employees.index') }}" class="flex items-center space-x-2">
                <input
                    type="text"
                    name="search"
                    class="rounded border px-2 py-1"
                    placeholder="Search by "
                    value="{{ request('search') }}">
                <button
                    type="submit"
                    style="background-color: #48bba3;"
                    class="text-white text-sm px-2 py-1 rounded hover:bg-gray-800">
                    <i class="fas fa-search"></i>
                    Search
                </button>
            </form>
        </div>

        <!-- Add Employee Button -->
        <button onclick="openModal()" style="background-color: #48bba3;" class="bg-gray-600 hover:bg-gray-800 text-sm text-white px-2 py-1 rounded">
            + Add Employee
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-3">
        {{ session('success') }}
    </div>
    @endif

    <!-- ✅ Employee Table -->
    <table class="w-full text-sm bg-white shadow rounded overflow-hidden ">
        <thead style="background-color: #64c5b1;" class="bg-gray-500 text-white">
            <tr class="border-b border-gray-300">
                <th class=" p-1">First Name</th>
                <th class="   p-1">Last Name</th>
                <th class="   p-1">Email</th>
                <th class="   p-1">Phone</th>
                <th class="   p-1">Address</th>
                <th class="   p-1">Gender</th>
                <th class="   p-1">Image</th>
                <th class="   p-1">Status</th>
                <th class="   p-1">Actions</th>
            </tr>
        </thead>

        <tbody class="text-xs">
            @foreach($employees as $employee)
            <tr class="odd:bg-white even:bg-gray-300">
                <td class=" border-b border-gray-300 text-center ">{{ $employee->first_name }}</td>
                <td class=" border-b border-gray-300 text-center ">{{ $employee->last_name }}</td>
                <td class=" border-b border-gray-300 text-center ">{{ $employee->email }}</td>
                <td class=" border-b border-gray-300 text-center ">{{ $employee->phone }}</td>
                <td class=" border-b border-gray-300 text-center ">{{ $employee->address }}</td>
                <td class=" border-b border-gray-300 text-center ">{{ $employee->gender }}</td>

                <td class=" border-b border-gray-300 text-center ">
                    @if($employee->image)
                    <img src="{{ asset('uploads/employees/' . $employee->image) }}" class=" border-b border-gray-300 w-12 h-12 rounded" />
                    @else
                    No Image
                    @endif
                </td>
                <td class="border-b border-shadow border-gray-300 text-center">
                    <span class=" px-2 py-1 text-xs {{ $employee->status }}">
                        {{ $employee->status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="border-b p-2 text-center flex items-center justify-center gap-2">
                    <!-- Edit Button -->
                    <button
                        onclick="editEmployee('{{ $employee->id }}','{{ $employee->first_name }}','{{ $employee->last_name }}','{{ $employee->email }}','{{ $employee->phone }}','{{ $employee->address }}','{{ $employee->gender }}','{{ $employee->status }}')"
                        class="bg-yellow-500 text-white text-xs px-2 py-1 rounded flex items-center justify-center border-none outline-none">
                        <i class="mdi mdi-pencil text-white"></i>
                    </button>

                    <!-- Delete Button -->
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="bg-red-600 text-xs text-white px-2 py-1 rounded flex items-center justify-center border-none outline-none"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $employees->links('pagination::tailwind') }}
    </div>
</div>

<!-- ✅ Modal UI -->
<div id="employeeModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded w-1/2">
        <h3 id="modalTitle" class="text-lg font-bold mb-4">Add Employee</h3>

        <form id="employeeForm" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-2 gap-3">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="employee_id" id="employee_id">

                <input type="text" name="first_name" placeholder="First Name" class="w-full    p-2 mb-2" required>
                <input type="text" name="last_name" placeholder="Last Name" class="w-full    p-2 mb-2" required>
                <input type="email" name="email" placeholder="Email" class="w-full    p-2 mb-2" required>
                <input type="text" name="phone" placeholder="Phone" class="w-full    p-2 mb-2" required>
                <input type="text" name="address" placeholder="Address" class="w-full    p-2 mb-2" required>

                <select name="gender" class="w-full    p-2 mb-2" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <input type="file" name="image" class="w-full    p-2 mb-3" accept="image/*">
                <!-- Image preview for edit -->
                <div id="imagePreview" class="hidden mt-2">
                    <img id="previewImg" src="" class="w-16 h-16 rounded   ">
                </div>

                <label class="flex items-center mb-2">
                    <input type="checkbox" id="status" name="status" value="1" checked class="mr-2"> Active
                </label>

            </div>
            <hr class="my-3   -t   -gray-300">
            <div class="flex justify-end mt-3">
                <button type="button" onclick="closeModal()" class="mr-2 bg-gray-300 px-4 py-2 rounded">
                    Cancel
                </button>
                <button class="bg-blue-600 px-4 py-2 text-white rounded">
                    Save
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    function openModal() {
        resetForm();
        document.getElementById('employeeModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('employeeModal').classList.add('hidden');
    }

    function resetForm() {
        document.getElementById("modalTitle").innerText = "Add Employee";
        document.getElementById("employeeForm").reset();
        document.getElementById("formMethod").value = "POST";
        document.getElementById("employeeForm").action = "{{ route('employees.store') }}";
    }

    function editEmployee(id, first_name, last_name, email, phone, address, gender, status) {
        document.getElementById("modalTitle").innerText = "Edit Employee";

        document.getElementById("employeeModal").classList.remove("hidden");

        document.getElementById("employee_id").value = id;
        document.querySelector("input[name='first_name']").value = first_name;
        document.querySelector("input[name='last_name']").value = last_name;
        document.querySelector("input[name='email']").value = email;
        document.querySelector("input[name='phone']").value = phone;
        document.querySelector("input[name='address']").value = address;
        document.querySelector("select[name='gender']").value = gender;
        // ✅ Show preview image if exists
        const imagePreviewDiv = document.getElementById("imagePreview");
        const previewImg = document.getElementById("previewImg");

        if (image) {
            imagePreviewDiv.classList.remove("hidden");
            previewImg.src = `/uploads/employees/${image}`;
        } else {
            imagePreviewDiv.classList.add("hidden");
            previewImg.src = "";
        }
        document.getElementById("status").checked = (status === "1" || status === 1);
        document.getElementById("formMethod").value = "PUT";
        document.getElementById("employeeForm").action = "/employees/" + id;
    }
</script>

@endsection