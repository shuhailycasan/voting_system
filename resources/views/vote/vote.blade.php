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

<div class="flex justify-center items-center h-100 border border-black">
    <div class="flex flex-col">
    <h2>Welcome, {{ Auth::user()->name }}</h2>
    <p class="text-lg">Select your candidate:</p>

    <form action="{{ route('vote.submit') }}" method="POST">
        @csrf
        @foreach ($candidates as $candidate)
            <div class>
                <input type="radio" name="candidate_id" value="{{ $candidate->id }}" required>
                <label>{{ $candidate->name }}
                    @if($candidate->position)
                        ({{ $candidate->position }})
                    @endif
                </label>
            </div>
        @endforeach

        <button type="submit">Submit Vote</button>
    </form>
    </div>
</div>
</body>
</html>
