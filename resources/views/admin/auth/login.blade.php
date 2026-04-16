<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso admin | Hechizos de Maria</title>
    <meta name="robots" content="noindex, nofollow">

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Cinzel:wght@500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background: linear-gradient(135deg, #fdf2f8 0%, #ffffff 50%, #fce7f3 100%);">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/images/branding/Logo-Hechizos-de-Maria.png" alt="Hechizos de Maria" class="h-16 mx-auto mb-4">
            <h1 class="font-heading text-2xl text-pink-700">Panel de administracion</h1>
        </div>

        <form method="POST" action="{{ route('admin.login.post') }}" class="bg-white border border-pink-200 rounded-2xl shadow-xl p-8 space-y-5">
            @csrf

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-md px-4 py-3 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full border border-gray-300 rounded-md px-4 py-3 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Contrasena</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-md px-4 py-3 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-100">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="remember" value="1" class="accent-pink-500">
                Recordarme
            </label>

            <button type="submit" class="w-full bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-bold uppercase tracking-widest py-3 rounded-md transition">
                Entrar
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6 uppercase tracking-widest">&copy; {{ date('Y') }} Hechizos de Maria</p>
    </div>

</body>
</html>
