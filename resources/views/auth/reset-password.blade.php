<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Benexpress</title>
    <!-- Tailwind CSS por CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Nueva Contraseña</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Correo Electrónico</label>
                <input id="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus autocomplete="username" />
                @error('email')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Nueva Contraseña</label>
                <input id="password" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-medium text-sm text-gray-700 mb-1">Confirmar Contraseña</label>
                <input id="password_confirmation" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" type="password" name="password_confirmation" required autocomplete="new-password" />
                @error('password_confirmation')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message} }</span>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">
                    Restablecer Contraseña
                </button>
            </div>
        </form>
    </div>
</body>
</html>