<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="flex flex-col items-center justify-center min-h-screen">


        <form action="{{ route('login') }}" method="POST"
            class="bg-white shadow-md rounded-2xl px-8 pt-6 pb-8 w-full max-w-md">
            @csrf
            <h1 class="text-center text-3xl font-bold mb-6">Login</h1>
            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" required autofocus
                    class="w-full border px-3 py-2 rounded focus:ring">
            </div>

            <div class="mb-6 relative">
                <label class="text-sm font-semibold text-gray-700">Password</label>

                <input type="password" name="password" id="password"
                    class="w-full border px-3 py-2 rounded focus:ring pr-10" required>

                <!-- Toggle Show/Hide Password -->
                <button type="button" id="togglePassword"
                    class="absolute right-3 top-10 text-gray-500 focus:outline-none">

                    <!-- Eye Open Icon (Show Password) -->
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>

                    <!-- Eye Closed Icon (Hide Password) -->
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3 3l18 18M10.58 10.58A3 3 0 0113.41 13.4M9.88 9.88l-.88-.88m6.12 6.12l.88.88M6.23 6.23C4.36 7.59 3 9.66 3 12c1.27 4.06 5.07 7 9.54 7 1.66 0 3.23-.4 4.61-1.14" />
                    </svg>

                </button>
            </div>


            email-> random -> otp -> new
            <button type="submit"
                class="bg-blue-600 w-full text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>

            <!-- Forgot Password  -->
            <form action="{{ route('forgot-password') }}" method="POST"
                class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:underline">
                    Forgot Your Password?
                </button>
            </form>

        </form>

        {{--Register User--}}
        <div class="mt-4 text-center">
            <p class="text-gray-700 text-sm">Don't have an account? <a href="{{ route('register') }}"
                    class="text-blue-600 hover:underline">Register here</a></p>
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