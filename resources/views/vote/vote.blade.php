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
<style>
    .candidate-box.selected {
        border-color: #10b981;
        /* emerald-500 */
        background-color: #d1fae5;
        /* light green bg */
    }
</style>

<body class=" text-[#1b1b18]">

    <div class="flex justify-center shadow-lg bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-700">
        <h1 class="p-8 text-3xl font-extrabold tracking-wide text-center text-white sm:text-4xl sm:p-10 animate-pulse">
            🗳️ CAST YOUR VOTES
        </h1>
    </div>


    <div class="flex items-start justify-center px-4 py-10">
        <div class="w-full max-w-4xl space-y-8">

            <form id="voteForm" action="{{ route('vote.submit') }}" method="POST">
                @csrf

                @foreach ($positions as $position)
                    <div class="mb-6">
                        <h2 class="mb-2 text-xl font-bold text-gray-800 dark:text-white">{{ $position->name }}</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-2">
                            @foreach ($position->candidates as $candidate)
                                <label for="candidate_{{ $candidate->id }}">
                                    <div class="p-4 text-center transition-all bg-white border-4 border-transparent shadow-md cursor-pointer hover:border-emerald-500 rounded-xl dark:bg-gray-800 candidate-box"
                                        onclick="selectCandidate(this, '{{ $position->id }}', '{{ $position->type }}')">
                                        <img src="{{ $candidate->getFirstMediaUrl('candidate_photo') }}"
                                            alt="Candidate Photo"
                                            class="object-cover w-24 h-24 mx-auto mb-2 rounded-full">
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $candidate->name }}
                                        </div>
                                        <input
                                            type="{{ $position->type == 'multiple' ? 'checkbox' : 'radio' }}"
                                            name="votes[{{ $position->id }}]{{ $position->type == 'multiple' ? '[]' : '' }}"
                                            id="candidate_{{ $candidate->id }}"
                                            value="{{ $candidate->id }}"
                                            class="hidden"
                                            data-position-name="{{ $position->name }}"
                                        >
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-center mt-10">
                    <button type="button" onclick="openConfirmation()"
                        class="w-[90%] sm:w-[600px] bg-emerald-500 hover:bg-emerald-600 text-white text-2xl font-bold py-6 px-12 rounded-2xl shadow-xl transition-all duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-emerald-300">
                        🗳️ Submit Vote
                    </button>
                </div>


            </form>

            {{-- Confirmation Modal --}}
            <div id="confirmationModal"
                class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-md bg-white/30">
                <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
                    <h2 class="mb-4 text-lg font-bold">Kumpirmado na ba ang iyong boto?</h2>
                    <ul id="voteSummaryList" class="mb-4 space-y-2 text-sm text-gray-700">
                        <!-- Summary goes here -->
                    </ul>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeConfirmation()"
                            class="px-4 py-2 text-white rounded bg-emerald-400">Hindi, pa
                        </button>
                        <button type="submit" form="voteForm" class="px-4 py-2 text-white rounded bg-emerald-600">Oo,
                            sigurado ako
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

{{-- Handle selection --}}
<script>
    function selectCandidate(el, positionId, type) {
        const container = el.closest('.grid');
        if (type === 'single') {
            // Unselect others
            container.querySelectorAll('.candidate-box').forEach(box => {
                box.classList.remove('selected');
                box.querySelector('input').checked = false;
            });
        }

        const input = el.querySelector('input');
        input.checked = !input.checked;
        el.classList.toggle('selected', input.checked);
    }
</script>


{{-- Vote Limit Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach ($positions as $position)
            @if ($position->type === 'multiple')
                const checkboxes{{ $position->id }} = document.querySelectorAll(
                    '.position-{{ $position->id }}');
                const max{{ $position->id }} = {{ $position->max_votes }};

                checkboxes{{ $position->id }}.forEach(box => {
                    box.addEventListener('change', () => {
                        let checked = [...checkboxes{{ $position->id }}].filter(c => c
                        .checked);
                        if (checked.length > max{{ $position->id }}) {
                            box.checked = false;
                            alert(
                                'You can only select up to {{ $position->max_votes }} candidate(s) for {{ $position->name }}');
                        }
                    });
                });
            @endif
        @endforeach
    });
</script>

<script>
    // Add event listener to every candidate card
    document.querySelectorAll('.candidate-card').forEach(card => {
        card.addEventListener('click', function() {
            setTimeout(highlightSelected, 10); // Let the browser handle the actual input click first
        });
    });

    // ALSO re-run highlight when a user checks box directly (not via card)
    document.querySelectorAll('.candidate-input').forEach(input => {
        input.addEventListener('change', highlightSelected);
    });

    function highlightSelected() {
        document.querySelectorAll('.candidate-card').forEach(card => {
            card.classList.remove('bg-emerald-600', 'text-white');
            card.classList.add('bg-emerald-100', 'text-black');
        });

        document.querySelectorAll('.candidate-input:checked').forEach(input => {
            const card = document.querySelector(
                `.candidate-card[data-position="${input.dataset.position}"][data-id="${input.dataset.id}"]`);
            if (card) {
                card.classList.remove('bg-emerald-100', 'text-black');
                card.classList.add('bg-emerald-600', 'text-white');
            }
        });
    }

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
            const positionName = input.dataset.positionName;
            if (!positionName) return; // 💥 skip anything without a proper name

            if (!grouped[positionName]) grouped[positionName] = [];

            const candidateName = input.closest('label')?.innerText.trim();
            if (candidateName) grouped[positionName].push(candidateName);
        });

        for (const positionName in grouped) {
            const li = document.createElement('li');
            const names = grouped[positionName].join(', ');
            li.innerHTML = `<strong>${positionName}:</strong> ${names}`;
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
