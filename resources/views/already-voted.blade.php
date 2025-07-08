<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="h-screen flex justify-center items-center flex-col">
    <h1 class="text-2xl font-bold text-red-600 mb-4">Nakapagboto ka na.</h1>
    <p class="text-gray-600">Ire-redirect ka pabalik sa login page...</p>
</div>

</body>
</html>
<script>
    // ⏱ Redirect after 3 seconds
    setTimeout(function () {
        window.location.href = "{{ route('login.form') }}";
    }, 3000);

</script>


User::create([
'name' => 'Admin Name',
'email' => 'admin@voting.com',
'password' => Hash::make('adminadmin'),
'role' => 'admin',
'code' => null,
'voted' => false,
]);
