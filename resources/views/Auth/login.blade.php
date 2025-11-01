<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex flex-col items-center justify-center min-h-screen">
        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="bg-white shadow-md rounded-2xl px-8 pt-6 pb-8 w-full max-w-md">
            @csrf
            <h1 class="text-center text-3xl font-bold mb-6">Login</h1>
            <div class="mb-4">
                <label class="text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" required autofocus class="w-full border px-3 py-2 rounded focus:ring">
            </div>
            <div class="mb-6 relative">
                <label class="text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full border px-3 py-2 rounded focus:ring pr-10" required>
                <button type="button" id="togglePassword" class="absolute right-3 top-10 text-gray-500 focus:outline-none">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.58 10.58A3 3 0 0113.41 13.4M9.88 9.88l-.88-.88m6.12 6.12l.88.88M6.23 6.23C4.36 7.59 3 9.66 3 12c1.27 4.06 5.07 7 9.54 7 1.66 0 3.23-.4 4.61-1.14" />
                    </svg>
                </button>
            </div>
            <button type="submit" class="bg-blue-600 w-full text-white py-2 rounded hover:bg-blue-700">
                Login
            </button>

            <!-- Trigger Forgot Password Modal -->
            <button type="button" onclick="openForgotModal()" class="mt-4 text-sm text-blue-600 hover:underline w-full">
                Forgot Your Password?
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-gray-700 text-sm">Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>
            </p>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h2 class="text-xl font-bold mb-4">Reset Password</h2>
            <p class="text-sm text-gray-600 mb-4">Enter your email to receive a 6-digit OTP.</p>

            <form id="forgotForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" id="fp_email" class="w-full border px-3 py-2 rounded mt-1" required>
                </div>
                <div id="otpSection" class="hidden">
                    <label class="block text-sm font-medium">OTP (6 digits)</label>
                    <input type="text" id="fp_otp" class="w-full border px-3 py-2 rounded mt-1" maxlength="6" required>
                    
                    <label class="block text-sm font-medium mt-3">New Password</label>
                    <input type="password" id="fp_password" class="w-full border px-3 py-2 rounded mt-1" minlength="6" required>
                    
                    <label class="block text-sm font-medium mt-3">Confirm Password</label>
                    <input type="password" id="fp_password_confirmation" class="w-full border px-3 py-2 rounded mt-1" required>
                </div>

                <div id="fpMessage" class="text-sm mt-2"></div>

                <div class="flex justify-between mt-4">
                    <button type="button" onclick="closeForgotModal()" class="px-4 py-2 text-gray-600">Cancel</button>
                    <button type="submit" id="fpSubmitBtn" class="px-4 py-2 bg-blue-600 text-white rounded">Send OTP</button>
                </div>
            </form>
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

        // Modal functions
        function openForgotModal() {
            document.getElementById('forgotModal').classList.remove('hidden');
            document.getElementById('otpSection').classList.add('hidden');
            document.getElementById('fpSubmitBtn').textContent = 'Send OTP';
            document.getElementById('fpMessage').innerHTML = '';
            document.getElementById('forgotForm').reset();
        }

        function closeForgotModal() {
            document.getElementById('forgotModal').classList.add('hidden');
        }

        // Handle form submission
        document.getElementById('forgotForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('fp_email').value;
            const otpSection = document.getElementById('otpSection');
            const btn = document.getElementById('fpSubmitBtn');
            const msg = document.getElementById('fpMessage');

            msg.innerHTML = '';

            if (!otpSection.classList.contains('hidden')) {
                // Reset password step
                const otp = document.getElementById('fp_otp').value;
                const password = document.getElementById('fp_password').value;
                const password_confirmation = document.getElementById('fp_password_confirmation').value;

                try {
                    const res = await axios.post("{{ route('password.reset') }}", {
                        email, otp, password, password_confirmation
                    });
                    msg.innerHTML = `<span class="text-green-600">${res.data.message}</span>`;
                    setTimeout(() => {
                        closeForgotModal();
                    }, 2000);
                } catch (err) {
                    const error = err.response?.data?.error || 'Something went wrong';
                    msg.innerHTML = `<span class="text-red-600">${error}</span>`;
                }
            } else {
                // Send OTP step
                try {
                    const res = await axios.post("{{ route('forgot-password.send') }}", { email });
                    msg.innerHTML = `<span class="text-green-600">${res.data.message}</span>`;
                    otpSection.classList.remove('hidden');
                    btn.textContent = 'Reset Password';
                } catch (err) {
                    const error = err.response?.data?.errors?.email?.[0] || 'Failed to send OTP';
                    msg.innerHTML = `<span class="text-red-600">${error}</span>`;
                }
            }
        });
    </script>
</body>
</html>