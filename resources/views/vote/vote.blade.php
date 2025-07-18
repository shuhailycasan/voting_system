<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Community Voting</title>

    <!-- Tailwind CDN (if not using Vite) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18]">

<div class="flex justify-center bg-emerald-700">
    <h1 class="text-lg text-center p-9 text-white font-bold">CAST YOUR VOTES</h1>
</div>

<div class="flex justify-center items-start py-10 px-4">
    <div class="w-full max-w-4xl space-y-8">

        <form id="voteForm" action="{{ route('vote.submit') }}" method="POST">
            @csrf

            @foreach ($positions as $position)
                <div class="p-4 bg-white shadow rounded-lg border border-gray-200">
                    <h2 class="text-xl font-bold mb-4">{{ $loop->iteration }}. {{ $position->name }}</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($candidates->where('position_id', $position->id) as $candidate)
                            <label class="block">
                                <input
                                    type="{{ $position->max_votes > 1 ? 'checkbox' : 'radio' }}"
                                    name="votes[{{ $position->slug }}]{{ $position->max_votes > 1 ? '[]' : '' }}"
                                    value="{{ $candidate->id }}"
                                    class="hidden candidate-input"
                                    data-position="{{ $position->slug }}"
                                    data-id="{{ $candidate->id }}"
                                >

                                <div
                                    class="candidate-card bg-emerald-100 text-center font-semibold rounded-lg p-4 cursor-pointer border border-emerald-400 hover:bg-blue-200 transition flex flex-col items-center space-y-2"
                                    data-position="{{ $position->slug }}"
                                    data-id="{{ $candidate->id }}"
                                >
                                    <img src="{{ $candidate->getFirstMediaUrl('candidate_photo') }}" alt="{{ $candidate->name }}"
                                         class="w-16 h-16 rounded-full object-cover mb-2">
                                    <div>{{ $candidate->name }}</div>
                                </div>
                            </label>
                        @endforeach

                    </div>
                </div>
            @endforeach

            <div class="text-right mt-4">
                <button type="button" onclick="openConfirmation()"
                        class="bg-emerald-500 hover:bg-emerald-600 rounded-lg py-2 px-4 text-white font-bold transition">
                    Submit Vote
                </button>
            </div>
        </form>

        {{-- Confirmation Modal --}}
        <div id="confirmationModal"
             class="hidden fixed inset-0 backdrop-blur-md bg-white/30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
                <h2 class="text-lg font-bold mb-4">Kumpirmado na ba ang iyong boto?</h2>
                <ul id="voteSummaryList" class="mb-4 text-sm space-y-2 text-gray-700">
                    <!-- Summary goes here -->
                </ul>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeConfirmation()"
                            class="px-4 py-2 bg-emerald-400 text-white rounded">Hindi, pa
                    </button>
                    <button type="submit" form="voteForm" class="px-4 py-2 bg-emerald-600 text-white rounded">Oo,
                        sigurado ako
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>

{{-- Vote Limit Script --}}
<script>
    document.querySelectorAll('input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function () {
            const pos = this.dataset.position;
            const max = parseInt(this.dataset.max || 1);
            const checked = document.querySelectorAll(`input[data-position="${pos}"]:checked`);
            if (checked.length > max) {
                this.checked = false;
                alert(`You can only select ${max} candidate(s) for ${formatPosition(pos)}.`);
            }
        });
    });
</script>

<script>
    document.querySelectorAll('.candidate-card').forEach(card => {
        card.addEventListener('click', function () {
            const position = this.dataset.position;
            const id = this.dataset.id;

            // Uncheck others if radio
            const inputs = document.querySelectorAll(`input[name="votes[${position}]"], input[name="votes[${position}][]"]`);
            if (inputs[0]?.type === 'radio') {
                inputs.forEach(i => {
                    i.checked = false;
                    removeHighlight(i.dataset.position, i.dataset.id);
                });
            }

            // Toggle check for checkbox
            const input = document.querySelector(`input[data-position="${position}"][data-id="${id}"]`);
            if (input.type === 'checkbox') {
                input.checked = !input.checked;
            } else {
                input.checked = true;
            }

            highlightSelected();
        });
    });

    function highlightSelected() {
        document.querySelectorAll('.candidate-card').forEach(card => {
            card.classList.remove('bg-emerald-600', 'text-white');
            card.classList.add('bg-emerald-100', 'text-black');
        });

        document.querySelectorAll('.candidate-input:checked').forEach(input => {
            const card = document.querySelector(`.candidate-card[data-position="${input.dataset.position}"][data-id="${input.dataset.id}"]`);
            if (card) {
                card.classList.remove('bg-emerald-100', 'text-black');
                card.classList.add('bg-emerald-600', 'text-white');
            }
        });
    }

    function removeHighlight(position, id) {
        const card = document.querySelector(`.candidate-card[data-position="${position}"][data-id="${id}"]`);
        if (card) {
            card.classList.remove('bg-emerald-600', 'text-white');
            card.classList.add('bg-emerald-100', 'text-black');
        }
    }

    // Auto-highlight on load if browser re-fills
    window.addEventListener('DOMContentLoaded', highlightSelected);
</script>


{{-- Confirmation Modal Script --}}
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
        const modal = document.getElementById('confirmationModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function formatPosition(pos) {
        return pos.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    }
</script>
