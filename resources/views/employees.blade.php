@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div>
    <div class="flex justify-between items-center mb-4">
        <div>
            <form method="GET" action="{{ route('employees.index') }}" class="flex items-center space-x-2">
                <input type="text" name="search" class="rounded border px-2 py-1" placeholder="Search Employee" value="{{ request('search') }}">
                <button type="submit" style="background-color: #48bba3;" class="text-white text-sm px-2 py-1 rounded hover:bg-gray-800">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <button onclick="openModal()" style="background-color: #48bba3;" class="text-white text-sm px-2 py-1 rounded">
            + Add Employee
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full text-sm bg-white shadow rounded overflow-hidden">
        <thead style="background-color: #64c5b1;" class="text-white">
            <tr class="border-b border-gray-300">
                <th class="p-1">Employee Name</th>
                <th class="p-1">Status</th>
                <th class="p-1">Actions</th>
            </tr>
        </thead>
        <tbody class="text-xs">
            @foreach($employees as $employee)
            <tr class="odd:bg-white even:bg-gray-200">
                <td class="text-center">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                <td class="text-center">
                    <span class="{{ $employee->status ? 'text-green-600' : 'text-red-600' }}">
                        {{ $employee->status ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="p-2 text-center flex items-center justify-center gap-2">
                    <a href="{{ route('employee_details', $employee->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded">
                        View Details
                    </a>
                    <button
                        onclick="editEmployee(
                        '{{ $employee->id }}', 
                        '{{ $employee->first_name }}', 
                        '{{ $employee->last_name }}', 
                        '{{ $employee->email }}', 
                        '{{ $employee->phone }}', 
                        '{{ $employee->address }}', 
                        '{{ $employee->gender }}', 
                        '{{ (int) $employee->status }}', 
                        '{{ $employee->image ?? '' }}'
                        )"
                        class="bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                        Edit
                    </button>
                    <button
                        data-action="{{ route('employees.destroy', $employee->id) }}"
                        onclick="openDeleteModal(this.dataset.action)"
                        class="bg-red-600 text-white text-xs px-2 py-1 rounded">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $employees->links('pagination::tailwind') }}
    </div>
</div>

<!-- ✅ ADD/EDIT EMPLOYEE MODAL -->
<div id="employeeModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded w-1/2 max-w-2xl">
        <h3 id="modalTitle" class="text-lg font-bold mb-4">Add Employee</h3>

        <form id="employeeForm" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="employee_id" id="employee_id">

            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="first_name" placeholder="First Name" class="w-full border rounded p-2" required>
                <input type="text" name="last_name" placeholder="Last Name" class="w-full border rounded p-2" required>
                <input type="email" name="email" placeholder="Email" class="w-full border rounded p-2" required>
                <input type="text" name="phone" placeholder="Phone" class="w-full border rounded p-2" required>
                <input type="text" name="address" placeholder="Address" class="w-full border rounded p-2" required>

                <select name="gender" class="w-full border rounded p-2" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <select name="status" id="status" class="w-full border rounded p-2" required>
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>

                <input type="file" name="image" class="w-full border rounded p-2" accept="image/*" onchange="previewImage(this)">
                <div id="imagePreview" class="hidden mt-2 col-span-2">
                    <img id="previewImg" class="w-16 h-16 rounded object-cover">
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- ✅ DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded w-1/3 max-w-md">
        <h3 class="text-lg font-bold mb-4">Confirm Delete</h3>
        <p>Are you sure you want to delete this employee?</p>
        <div class="flex justify-end mt-4">
            <button type="button" onclick="closeDeleteModal()" class="bg-gray-300 px-4 py-2 rounded mr-2">Cancel</button>
            <button type="button" onclick="deleteEmployee()" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        resetForm();
        document.getElementById("employeeModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("employeeModal").classList.add("hidden");
    }

    function closeDeleteModal() {
        document.getElementById("deleteModal").classList.add("hidden");
    }

    let deleteUrl = '';

    function openDeleteModal(actionUrl) {
        deleteUrl = actionUrl;
        document.getElementById("deleteModal").classList.remove("hidden");
    }

    function deleteEmployee() {
        const button = document.querySelector('#deleteModal button:last-child');
        button.disabled = true;
        button.innerText = 'Deleting...';

        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                throw new Error(data.message || 'Delete failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting employee: ' + error.message);
            button.disabled = false;
            button.innerText = 'Delete';
        })
        .finally(() => {
            closeDeleteModal();
        });
    }

    function resetForm() {
        document.getElementById("modalTitle").innerText = "Add Employee";
        document.getElementById("employeeForm").reset();
        document.getElementById("formMethod").value = "POST";
        document.getElementById("employeeForm").action = "{{ route('employees.store') }}";
        document.getElementById("imagePreview").classList.add("hidden");
    }

    function previewImage(input) {
        const previewDiv = document.getElementById("imagePreview");
        const previewImg = document.getElementById("previewImg");

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewDiv.classList.remove("hidden");
                previewImg.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.classList.add("hidden");
        }
    }

    function editEmployee(id, first_name, last_name, email, phone, address, gender, status, image) {
        document.getElementById("modalTitle").innerText = "Edit Employee";
        document.getElementById("employeeModal").classList.remove("hidden");

        document.getElementById("employee_id").value = id;
        document.querySelector("input[name='first_name']").value = first_name;
        document.querySelector("input[name='last_name']").value = last_name;
        document.querySelector("input[name='email']").value = email;
        document.querySelector("input[name='phone']").value = phone;
        document.querySelector("input[name='address']").value = address;
        document.querySelector("select[name='gender']").value = gender;
        document.getElementById("status").value = status;

        const previewDiv = document.getElementById("imagePreview");
        const previewImg = document.getElementById("previewImg");

        if (image) {
            previewDiv.classList.remove("hidden");
            previewImg.src = `/uploads/employees/${image}`;
        } else {
            previewDiv.classList.add("hidden");
        }

        document.getElementById("formMethod").value = "PUT";
        document.getElementById("employeeForm").action = `/employees/${id}`;
    }
</script>

@endsection