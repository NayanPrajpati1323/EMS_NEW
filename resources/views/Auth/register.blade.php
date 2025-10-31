<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex flex-col items-center justify-center min-h-screen">

        <form action="{{ route('register') }}" method="POST"
            class="bg-white shadow-md rounded-2xl px-8 pt-6 pb-8 w-full max-w-md">
            @csrf
             <h1 class="text-center text-3xl font-bold mb-6">Register</h1>

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full border px-3 py-2 rounded focus:ring @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border px-3 py-2 rounded focus:ring @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-4">
                <label class="text-sm font-semibold text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border px-3 py-2 rounded focus:ring @error('password') border-red-500 @enderror">

                <button type="button" id="togglePassword"
                    class="absolute right-3 top-10 text-gray-600">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 block" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3l18 18M10.58 10.58A3 3 0 0113.41 13.4" />
                    </svg>
                </button>
            </div>

            <div class="relative mb-6">
                <label class="text-sm font-semibold text-gray-700">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full border px-3 py-2 rounded focus:ring">

                <button type="button" id="togglePassword" 
                    class="absolute right-3 top-10 text-gray-600">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 block" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3l18 18M10.58 10.58A3 3 0 0113.41 13.4" />
                    </svg>
                </button>
            </div>


            <button type="submit"
                class="bg-blue-600 w-full text-white py-2 rounded hover:bg-blue-700">
                Register
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-gray-700 text-sm">Already have an account? <a href="{{ route('login') }}"
                    class="text-blue-600 hover:underline">Login here</a></p>
        </div>
    </div>


    <script>
        const password = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        togglePassword.addEventListener('click', () => {
            const isPasswordVisible = password.getAttribute('type') === 'text';

            password.setAttribute('type', isPasswordVisible ? 'password' : 'text');

            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    </script>
</body>

</html>