<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title', config('app.name'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="flex">

        {{-- Sidebar --}}
        <aside 
            style="background-color: #343c49; width: 240px;" 
            class="fixed left-0 top-0 h-screen w-64 text-white p-4 flex flex-col overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800">
            <h2 class="text-2xl font-bold mb-6 text-center tracking-wide sticky top-0 py-2 z-10">
                EMS
            </h2>

            <ul class="space-y-2 flex-1">

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-between p-2 rounded hover:bg-gray-700 transition">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 12l9-9m0 0l9 9M4.5 12v7.5A1.5 1.5 0 006 21h3m0 0v-6h6v6m0 0h3a1.5 1.5 0 001.5-1.5V12" />
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </li>

                {{-- Employees --}}
                <li>
                    <a href="{{ route('employees.index') }}"
                        class="flex items-center justify-between p-2 rounded hover:bg-gray-700 transition">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0" />
                            </svg>
                            <span>Employees</span>
                        </div>
                    </a>
                </li>

                {{-- Reports --}}
                <li>
                    <a href="#"
                        class="flex items-center justify-between p-2 rounded hover:bg-gray-700 transition">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-6h6v6m3 4H6a2 2 0 01-2-2V5a2 2 0 012-2h9l6 6v10a2 2 0 01-2 2z" />
                            </svg>
                            <span>Reports</span>
                        </div>
                    </a>
                </li>

                {{-- Settings --}}
                <li>
                    <a href="#"
                        class="flex items-center justify-between p-2 rounded hover:bg-gray-700 transition">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.25 3a8.25 8.25 0 018.25 8.25 8.25 8.25 0 01-8.25 8.25A8.25 8.25 0 013 11.25 8.25 8.25 0 0111.25 3z" />
                            </svg>
                            <span>Settings</span>
                        </div>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="mt-6">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 p-2 rounded hover:bg-red-700 w-full text-left transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3H6A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5a2.25 2.25 0 002.25-2.25V15M9 12h12m0 0l-3-3m3 3l-3 3" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>

            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 ml-60 flex flex-col min-h-screen">

            {{-- Navbar --}}
            <nav style="background-color: #64c5b1;"
                class="top-0 z-20 bg-white shadow p-4 flex justify-between items-center">
                @php
                    $routeName = request()->route()->getName();
                    $routeBase = explode('.', $routeName)[0];
                    $pageTitle = ucfirst($routeBase);
                @endphp

                <span class="font-semibold text-lg text-white">
                    {{ $pageTitle ?? 'Dashboard' }}
                </span>

                <span id="themeToggle" class="cursor-pointer text-xl">🌙</span>
            </nav>

            {{-- Page Content --}}
            <main class="p-6 text-gray-900 bg-gray-100 min-h-screen overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- ✅ Dark Mode Toggle Script --}}
    <script>
        const themeToggle = document.getElementById('themeToggle');

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            themeToggle.textContent =
                document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
        });
    </script>

    {{-- ✅ Custom Scrollbar --}}
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f2c2d;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b7678;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #4b8f91;
        }
    </style>
</body>

</html>
