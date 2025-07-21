<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="h-screen flex justify-center items-center flex-col">
    <h1 class="text-2xl font-bold text-red-600 mb-4">Nakapagboto ka na.</h1>
    <p class="text-gray-600">
        Ire-redirect ka pabalik sa login page in <span id="countdown" class="font-semibold">3</span>...
    </p>
</div>

<script>
    let countdown = 3;
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
