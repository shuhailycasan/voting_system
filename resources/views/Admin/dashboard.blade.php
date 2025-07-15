<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <title>DASHBOARD</title>
</head>
<body>

<div class="flex min-h-screen ">

    <aside class=" mr-3 w-10 h-screen fixed top-0 left-0 bg-white border-r z-50">
        @include('Admin.sidebar')
    </aside>

    <div class="flex-1 ">
        @yield('content')
    </div>
</div>

@stack('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
