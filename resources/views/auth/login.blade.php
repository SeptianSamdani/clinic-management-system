<!-- ========================================== -->
<!-- resources/views/auth/login.blade.php -->
<!-- ========================================== -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Sehat Sejahtera</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-full mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Klinik Sehat Sejahtera</h1>
            <p class="text-gray-600 mt-2">Sistem Manajemen Klinik</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Login</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    <p class="font-semibold">{{ $errors->first() }}</p>
                </div>
            @endif

            <!-- VULNERABLE FORM - NO CSRF TOKEN -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                <!-- Email Field -->
                <div>
                    <label for="email" class="label">Email</label>
                    <input 
                        type="text" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        class="input-field" 
                        placeholder="email@example.com"
                        autofocus
                    >
                    <p class="mt-1 text-xs text-gray-500">Masukkan email Anda</p>
                </div>

                <!-- Password Field -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="label">Password</label>
                    <div class="relative">
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            id="password" 
                            class="input-field pr-10" 
                            placeholder="••••••••"
                        >
                        <button 
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full btn-primary py-3 text-lg">
                    Login
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-600 mb-3 font-semibold">Demo Credentials:</p>
                <div class="space-y-2 text-xs text-gray-500">
                    <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                        <span class="font-medium">Admin:</span>
                        <code class="bg-gray-200 px-2 py-1 rounded">admin@klinik.com / password</code>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                        <span class="font-medium">Dokter:</span>
                        <code class="bg-gray-200 px-2 py-1 rounded">budi.santoso@klinik.com / password</code>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                        <span class="font-medium">Pasien:</span>
                        <code class="bg-gray-200 px-2 py-1 rounded">andi.pratama1@email.com / password</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Message (for educational purpose) -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-yellow-800">Peringatan - Sistem Vulnerable</p>
                    <p class="text-xs text-yellow-700 mt-1">Aplikasi ini sengaja dibuat vulnerable untuk keperluan praktikum forensika digital. Jangan gunakan di production!</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            © 2024 Klinik Sehat Sejahtera. Forensic Training Version.
        </p>
    </div>

</body>
</html>