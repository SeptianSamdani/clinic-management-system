<!-- resources/views/forensic/login.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forensic Dashboard - Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-gray-800 rounded-lg shadow-2xl p-8 border border-red-500">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-full mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Forensic Dashboard</h1>
                <p class="text-gray-400 mt-2">Investigasi & Analisis Log Keamanan</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-4 bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('forensic.authenticate') }}">
                <div class="mb-6">
                    <label class="block text-gray-300 text-sm font-medium mb-2">
                        Password Forensik
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="Masukkan password forensik"
                        autofocus
                        required
                    >
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition">
                    Akses Dashboard
                </button>
            </form>

            <!-- Info -->
            <div class="mt-6 p-4 bg-yellow-900 border border-yellow-700 rounded-lg">
                <p class="text-yellow-200 text-xs">
                    <strong>⚠️ Area Restricted:</strong> Dashboard ini hanya untuk investigator forensik digital.
                </p>
                <p class="text-yellow-300 text-xs mt-2">
                    Default password: <code class="bg-yellow-800 px-2 py-1 rounded">forensic123</code>
                </p>
            </div>
        </div>
    </div>
</body>
</html>