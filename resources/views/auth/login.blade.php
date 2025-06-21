<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login GOR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/dashboard.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
            font-family: 'Orbitron', sans-serif;
            overflow: hidden;
        }

        .cyber-card {
            background: var(--bg-card);
            padding: 1.5rem;
            border-radius: 12px;
            border: 3px solid #ff69b4;
            box-shadow: 5px 5px 0 #000, 10px 10px 0 #8b5cf6;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .cyber-button {
            border-radius: 1rem;
            border: px solid var(--primary-purple);
            position: relative;
            background: linear-gradient(135deg,
                    rgba(0, 245, 255, 0.1) 0%,
                    rgba(139, 92, 246, 0.1) 50%,
                    rgba(255, 20, 147, 0.1) 100%);
            ;
        }

        .cyber-button:hover {
            background: radial-gradient(circle farthest-corner at 10% 20%, rgba(255, 94, 247, 1) 17.8%, rgba(2, 245, 255, 1) 100.2%);
            box-shadow: 0 0 10px #0ff, 0 0 20px rgba(255, 94, 247, 1);
        }

        .neon-text {
            color: #0ff;
            text-shadow: 0 0 5px #0ff, 0 0 10px #0ff;
        }

        .error-text {
            color: #f00;
        }
    </style>
</head>

<body class="cursor-page-on flex items-center justify-center min-h-screen relative">

    <!-- Daun Jatuh -->
    <div id="leaf-container"></div>

    <div class="w-full max-w-md p-8 cyber-card text-white z-10">
        <h2 class="text-3xl font-bold mb-[55px] text-center neon-text">Login ke Akun Anda</h2>

        <!-- SweetAlert Error (Optional) -->
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#0ff'
                });
            </script>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-[55px] form-container">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" placeholder="Username" value="{{ old('email') }}"
                    required autofocus class="form-input-b smooth-type" />
                @error('email')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-[25px] form-container">
                <label for="password" class="form-label">Password</label>
                <div class="relative w-full">
                    <input id="password" type="password" name="password" required
                        class="form-input-b smooth-type pr-12" placeholder="Password" />
                    <button type="button" onclick="togglePassword()"
                        class="absolute right-3 top-6 -translate-y-1/3 text-gray-600">
                        <i id="toggleIcon" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-4">
                <label class="flex items-center text-cyan-300 text-sm">
                    <input type="checkbox" name="remember"
                        class="w-3 h-3 accent-cyan-400 bg-black border-cyan-400 mr-2" />
                    Ingat Saya
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-cyan-400 hover:underline text-sm">Lupa
                        Password?</a>
                @endif
            </div>

            <!-- Tombol Login -->
            <div>
                <button type="submit" class="w-full mt-4 cyber-button font-bold py-2 px-4">
                    Masuk
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-cyan-400 hover:underline font-semibold">
                Daftar sekarang
            </a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';
            toggleIcon.className = isPassword ? 'fas fa-eye' : 'fas fa-eye-slash';
        }
    </script>
</body>

</html>
