<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vote Login</title>

    <!-- Font and Tailwind -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html { font-family: 'Instrument Sans', sans-serif; }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

@include('components.top-nav')

<div class="flex-grow flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-emerald-600">
        @if (session('error'))
            <p class="mb-4 bg-red-100 text-red-700 text-center px-3 py-2 rounded font-semibold">
                {{ session('error') }}
            </p>
        @endif

        <form action="{{ route('vote.code.login') }}" method="POST" id="voteForm">
            @csrf

            <h1 class="text-2xl font-extrabold text-center text-emerald-700 mb-6">Enter 6-Digit Voting Code</h1>

            <div class="flex justify-between gap-2 mb-6">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="tel"
                           id="code-{{ $i }}"
                           maxlength="1"
                           pattern="[0-9]"
                           required
                           class="w-full max-w-[48px] aspect-square text-center text-xl font-bold text-gray-900 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"/>
                @endfor
            </div>

            <input type="hidden" name="code" id="full-code"/>

            <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-2 rounded-md transition">
                Submit Code
            </button>

            <p class="mt-4 text-sm text-center text-gray-500">
                I-type ang iyong 6-digit na code upang bumoto.
            </p>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputs = document.querySelectorAll('input[id^="code-"]');
        const hiddenInput = document.getElementById("full-code");
        const form = document.getElementById("voteForm");

        inputs.forEach((input, index) => {
            input.addEventListener("input", function () {
                this.value = this.value.replace(/[^0-9]/g, '');

                if (this.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                // Auto-fill full-code
                const code = Array.from(inputs).map(i => i.value).join('');
                hiddenInput.value = code;
            });

            input.addEventListener("keydown", function (e) {
                if (e.key === "Backspace" && this.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>

</body>
</html>
