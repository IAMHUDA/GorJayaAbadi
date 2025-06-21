<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi GOR</title>
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

        .register-container {
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid #0ff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 20px #0ff;
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

        .error-text {
            color: #f00;
        }
    </style>
</head>

<body class="cursor-page-on flex items-center justify-center min-h-screen relative">
    <div class="w-full max-w-md cyber-card">
        <h2 class="text-2xl font-bold mb-[65px] text-center text-cyan-300">Daftar Akun Baru</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-[55px] form-container">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" name="name" placeholder="Nama" value="{{ old('name') }}"
                    required autofocus class="form-input-b smooth-type" />
                @error('name')
                    <p class="error-text text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-[55px] form-container">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                    required class="form-input-b smooth-type" />
                @error('email')
                    <p class="error-text text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-[55px] form-container">
                <label for="password" class="form-label">Password</label>
                <div class="relative w-full">
                    <input id="password" type="password" name="password" class="form-input-b smooth-type pr-12"
                        placeholder="Password" required />
                    <button type="button" onclick="togglePassword('password', 'toggleIconPassword')"
                        class="absolute right-3 top-6 -translate-y-1/3 text-gray-600">
                        <i id="toggleIconPassword" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <p class="error-text text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-[25px] form-container">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="relative w-full">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-input-b smooth-type pr-12" placeholder="Confirm Password" required />
                    <button type="button" onclick="togglePassword('password_confirmation', 'toggleIconConfirm')"
                        class="absolute right-3 top-6 -translate-y-1/3 text-gray-600">
                        <i id="toggleIconConfirm" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="error-text text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div>
                <button type="submit" class="w-full mt-4 cyber-button font-bold py-2 px-4">
                    Daftar
                </button>
            </div>
        </form>
        <div class="mt-6 text-center text-sm">
            Belum punya akun?
            <a href="{{ route('login') }}" class="text-cyan-400 hover:underline font-semibold">
                Masuk
            </a>
        </div>
    </div>

    <!-- SweetAlert for validation error -->
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.className = "fas fa-eye";
            } else {
                input.type = "password";
                icon.className = "fas fa-eye-slash";
            }
        }

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mendaftar',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#0ff',
                    background: '#1f2937',
                    color: '#0ff'
                });
            });
        @endif
    </script>


</body>

</html>
