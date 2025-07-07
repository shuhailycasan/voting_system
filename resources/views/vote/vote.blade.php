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
<div class="flex justify-center bg-emerald-700">
    <h1 class="text-lg text-center p-9 text-white font-bold">CAST YOUR VOTES</h1>
</div>
<div class="flex justify-center items-center h-auto border border-black">
    <div class="flex flex-col pb-2">

        <h1 class="text-xl font-bold ">Pumili ng Kandidato</h2>

            <form action="{{ route('vote.submit') }}" method="POST">
                @csrf

                <div class="p-3 m-3 bg-color shadow">
                    <h2 class="text-xl font-bold mb-2">1.Isang boto para sa Presidente</h2>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($candidates->where('position', 'President') as $candidate)
                            <label class="block">
                                <input type="radio" name="votes[President]" value="{{ $candidate->id }}"
                                       id="president-{{ $candidate->id }}" class="hidden peer" required>
                                <div
                                    class="peer-checked:bg-emerald-600 peer-checked:text-white bg-emerald-100 text-center font-semibold rounded-lg p-4 cursor-pointer border border-emerald-400 hover:bg-blue-200 transition">
                                    {{ $candidate->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="p-3  m-3 bg-color shadow">
                    <h2 class="text-xl font-bold mb-2">2. Isang boto para sa Bise-Presidente</h2>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($candidates->where('position', 'Vice-President') as $candidate)
                            <label class="block">
                                <input type="radio" name="votes[Vice-President]" value="{{ $candidate->id }}"
                                       id="vice-president-{{ $candidate->id }}" class="hidden peer" required>
                                <div
                                    class="peer-checked:bg-emerald-600 peer-checked:text-white bg-emerald-100 text-center font-semibold rounded-lg p-4 cursor-pointer border border-emerald-400 hover:bg-blue-200 transition">
                                    {{ $candidate->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="p-3 m-3 bg-color shadow">
                    <h2 class="text-xl font-bold mb-2">3. Isang boto para sa Sekritarya</h2>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($candidates->where('position', 'Secretary') as $candidate)
                            <label class="block">
                                <input type="radio" name="votes[Secretary]" value="{{ $candidate->id }}"
                                       id="Secretary-{{ $candidate->id }}" class="hidden peer" required>
                                <div
                                    class="peer-checked:bg-emerald-600 peer-checked:text-white bg-emerald-100 text-center font-semibold rounded-lg p-4 cursor-pointer border border-emerald-400 hover:bg-blue-200 transition">
                                    {{ $candidate->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="p-3 m-3 bg-color shadow">
                    <h2 class="text-xl font-bold mb-2">4. Dalawang boto para sa Business Manager</h2>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($candidates->where('position', 'business_manager') as $candidate)
                            <label class="block">
                                <input type="checkbox" name="votes[business_manager][]" value="{{ $candidate->id }}"
                                       class="hidden peer">
                                <div
                                    class="peer-checked:bg-emerald-600 peer-checked:text-white bg-emerald-100 text-center font-semibold rounded-lg p-4 cursor-pointer border border-emerald-400 hover:bg-blue-200 transition">
                                    {{ $candidate->name }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button class="bg-emerald-500 rounded-lg py-1 px-2 text-white font-bold"
                        onclick="openConfirmation()" type="button">Submit Vote
                </button>
            </form>

            <!-- Confirmation Modal -->
            <div id="confirmationModal"
                 class="fixed inset-0 backdrop-blur-md bg-white/30 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 w-100 max-w-md">
                    <h2 class="text-lg font-bold mb-4">Kumpirmado na ba ang iyong boto?</h2>
                    <ul id="voteSummaryList" class="mb-4 text-sm space-y-2 text-gray-700">
                        <!-- Choices get filled in here -->
                    </ul>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeConfirmation()"
                                class="px-4 py-2 bg-emerald-400 text-white rounded">hindi, pa
                        </button>
                        <button type="submit" form="voteForm" class="px-4 py-2 bg-emerald-600 text-white rounded">
                            Oo, sigurado ako
                        </button>
                    </div>
                </div>
            </div>
    </div>
</div>
</body>
</html>

{{--scripts for Voting 2--}}
<script>
    document.querySelectorAll('input[name="votes[business_manager][]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const checked = document.querySelectorAll('input[name="votes[business_manager][]"]:checked');
            if (checked.length > 2) {
                this.checked = false;
                alert('You can only select 2 Business Managers.');
            }
        });
    });
</script>

{{--scripts for modals--}}
<script>
    function openConfirmation() {
        const votes = document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked');
        const summaryList = document.getElementById('voteSummaryList');
        summaryList.innerHTML = '';

        const grouped = {};

        votes.forEach(input => {
            const [_, position] = input.name.match(/votes\[([^\]]+)\]/) || [];
            if (!grouped[position]) grouped[position] = [];
            grouped[position].push(input.closest('label')?.innerText.trim());
        });

        for (const position in grouped) {
            const names = grouped[position].join(', ');
            const li = document.createElement('li');
            li.innerHTML = `<strong>${formatPosition(position)}:</strong> ${names}`;
            summaryList.appendChild(li);
        }

        document.getElementById('confirmationModal').classList.remove('hidden');
        document.getElementById('confirmationModal').classList.add('flex');
    }

    function closeConfirmation() {
        document.getElementById('confirmationModal').classList.add('hidden');
        document.getElementById('confirmationModal').classList.remove('flex');
    }

    function formatPosition(pos) {
        return pos
            .replace(/_/g, ' ')
            .replace(/\b\w/g, c => c.toUpperCase());
    }
</script>
