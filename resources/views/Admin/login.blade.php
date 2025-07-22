<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>ADMIN LOGIN</title>
</head>
<body>

<div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
    <div class="w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 space-y-6 border border-emerald-600">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Panel</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Restricted access only</p>
        </div>

        @if (session('error'))
            <div class="text-sm text-red-600 text-center font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Admin Name</label>
                <input type="text" name="name" id="name" autocomplete="name" required
                       class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
            </div>

            <div>
                <label for="password"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                <input type="password" name="password" id="password" autocomplete="current-password" required
                       class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-700 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                <div class="mt-2 text-right">
                    <a href="#" class="text-sm text-emerald-600 hover:text-emerald-500 font-medium">Forgot password?</a>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center items-center rounded-md bg-emerald-600 hover:bg-emerald-500 px-4 py-2 text-white font-semibold text-sm shadow-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">
                    Sign in
                </button>
            </div>
        </form>
    </div>
</div>


</body>
</html>
