<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>DASHBOARD</title>
</head>
<body>

<div class="flex min-h-screen">
    @include('Admin/sidebar');

    <div class="flex-1 p-6 ">
        @yield('content')
    </div>
</div>


</body>
</html>
