<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salamat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

<div class="min-h-screen flex flex-col justify-center items-center px-4 text-center">
    <h1 class="text-4xl sm:text-5xl font-extrabold text-emerald-600 mb-6 animate-pulse">
        Salamat sa iyong boto!
    </h1>
    <p class="text-base sm:text-lg text-gray-700 dark:text-gray-300 mb-2">
        Ire-redirect ka sa susunod na botante...
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        (Automatic in <span id="countdown">5</span> seconds)
    </p>
</div>

<script>
    let countdown = 5;
    const countdownEl = document.getElementById('countdown');

    const interval = setInterval(() => {
        countdown--;
        countdownEl.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(interval);
            window.location.href = "{{ route('login.form') }}";
        }
    }, 1000);
</script>

</body>
</html>
