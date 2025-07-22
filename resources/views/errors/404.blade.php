<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 | Lost in the Void</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen p-4">
<div class="max-w-xl w-full text-center space-y-6">
    {{-- Sad Anime Vibes --}}
    <img
        src="https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExYThzbnl0MGMwbGY4NnY5OHprbW8zY29scGFmNzVxcXR3dTk5Znh4cSZlcD12MV9naWZzX3NlYXJjaCZjdD1n/Bc6DQ6B8pXq1a/giphy.gif"
        alt="Sad Anime"
        class="mx-auto w-64 rounded-xl shadow-lg ring-4 ring-emerald-500 animate-pulse"
    >

    {{-- Big Animated 404 --}}
    <h1 class="text-7xl font-extrabold text-emerald-500 animate-bounce">404</h1>
    <p class="text-2xl font-semibold text-gray-300">Ayy... this page doesn’t exist.</p>
    <p class="text-sm text-gray-400">Maybe it ran away with your last braincell?</p>

    {{-- Back Button --}}
    <a
        href="{{ route('login.form') }}"
        class="inline-block mt-4 px-6 py-3 rounded-full bg-emerald-600 hover:bg-pink-700 transition duration-300 font-bold shadow-md"
    >
        🏠 Bring me back!
    </a>
</div>
</body>
</html>
