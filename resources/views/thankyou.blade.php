<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>
<body>
<div class="h-screen flex justify-center items-center flex-col">
    <h1 class="text-3xl font-bold text-emerald-700 mb-4">Salamat sa iyong boto!</h1>
    <p class="text-gray-600">Ire-redirect ka sa susunod na botante...</p>
</div>


</body>
</html>
<script>
    // Wait 5 seconds then redirect to code login form
    setTimeout(function () {
        window.location.href = "{{ route('login.form') }}";
    }, 5000); // 5000ms = 5 seconds
</script>
