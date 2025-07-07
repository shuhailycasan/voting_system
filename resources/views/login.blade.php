<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] ">
@include('components.top-nav')


<div class="flex justify-center items-center border border-emerald-500 h-svh">
    <div class="flex flex-col bg-white shadow height-100 p-10">
        @if (session('error'))
            <p class="bg-[#e20808] text-center text-white rounded-lg px-1 py-1 w-45">{{ session('error') }}</p>
        @endif

        <form action="{{ route('vote.code.login') }}" method="POST" class="max-w-sm mx-auto">
            @csrf
            <h1 class="text-xl font-bold mb-4">Enter Vote Login Code</h1>

            <div class="flex  mb-4 space-x-2 rtl:space-x-reverse">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" maxlength="1" id="code-{{ $i }}"
                           class="block w-full  py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                           required/>
                @endfor
            </div>

            {{-- Hidden input to combine code --}}
            <input type="hidden" name="code" id="full-code"/>

            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-bold rounded hover:bg-blue-700">
                Submit Code
            </button>

            <p class="mt-2 text-sm text-gray-500">Please enter the 6-digit code you receive upon entering the room.</p>
        </form>
    </div>
</div>

</body>
</html>

<script>
    const inputs = [...document.querySelectorAll('input[type="text"][id^=code-]')];
    const hiddenInput = document.getElementById('full-code');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            // Go to next input
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            // Update hidden input
            const code = inputs.map(i => i.value).join('');
            hiddenInput.value = code;
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && input.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
</script>
