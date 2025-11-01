@extends('layouts.app')

@section('content')
<div class="p-8 space-y-10">

    <!-- 🔹 Page Header -->
    <div class="flex justify-between items-center">
        <p class="text-gray-500 dark:text-gray-400 text-sm">Updated: {{ now()->format('d M Y, h:i A') }}</p>
    </div>

    <!-- 🔹 Top Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Employees -->
        <div
            class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl shadow-xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl animate-fadeIn">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium opacity-80">Total Employees</h3>
                    <p class="text-4xl font-extrabold mt-2 counter" data-target="{{ $totalEmployees }}">0</p>
                </div>
                <div class="p-4 bg-white/20 rounded-xl">
                    <i class="fas fa-users text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Employees -->
        <div
            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl shadow-xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl animate-fadeIn delay-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium opacity-80">Active Employees</h3>
                    <p class="text-4xl font-extrabold mt-2 counter" data-target="{{ $activeEmployees }}">0</p>
                </div>
                <div class="p-4 bg-white/20 rounded-xl">
                    <i class="fas fa-user-check text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Inactive Employees -->
        <div
            class="bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-2xl shadow-xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl animate-fadeIn delay-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium opacity-80">Inactive Employees</h3>
                    <p class="text-4xl font-extrabold mt-2 counter" data-target="{{ $inactiveEmployees }}">0</p>
                </div>
                <div class="p-4 bg-white/20 rounded-xl">
                    <i class="fas fa-user-slash text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Gender Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div
            class="bg-gradient-to-r from-cyan-500 to-sky-600 text-white rounded-2xl shadow-xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl animate-fadeIn delay-300">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium opacity-80">Males</h3>
                    <p class="text-4xl font-extrabold mt-2 counter" data-target="{{ $males }}">0</p>
                </div>
                <div class="p-4 bg-white/20 rounded-xl">
                    <i class="fas fa-male text-3xl"></i>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-r from-pink-500 to-fuchsia-600 text-white rounded-2xl shadow-xl p-6 transform transition-all hover:scale-105 hover:shadow-2xl animate-fadeIn delay-400">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium opacity-80">Females</h3>
                    <p class="text-4xl font-extrabold mt-2 counter" data-target="{{ $females }}">0</p>
                </div>
                <div class="p-4 bg-white/20 rounded-xl">
                    <i class="fas fa-female text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
        <!-- Employee Status Chart -->
        <div class="bg-gray-200 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700  mb-4">Employee Status</h3>
            <canvas id="statusChart" height="120"></canvas>
        </div>

        <!-- Gender Distribution Chart -->
        <div class="bg-gray-200  rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Gender Distribution</h3>
            <canvas id="genderChart" height="120"></canvas>
        </div>
    </div>

</div>

<!-- ✅ FontAwesome & Chart.js -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ✅ Animated Counters -->
<script>
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const speed = 50; // smaller = faster
            const increment = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 40);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });
</script>

<!-- ✅ Chart.js Graphs -->
<script>
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: ['{{ $activeEmployees }}', '{{ $inactiveEmployees }}'],
                backgroundColor: ['#10B981', '#EF4444'],
                borderWidth: 2,
                hoverOffset: 8
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#374151' }
                }
            }
        }
    });

    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: ['Males', 'Females'],
            datasets: [{
                data: ['{{ $males }}', '{{ $females }}'],
                backgroundColor: ['#06B6D4', '#EC4899'],
                borderWidth: 2,
                hoverOffset: 8
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#374151' }
                }
            }
        }
    });
</script>

<!-- ✅ Fade Animation -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.8s ease forwards;
    }

    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
</style>
@endsection
