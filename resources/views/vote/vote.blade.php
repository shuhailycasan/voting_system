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
        border-color: #10b981; /* emerald-500 */
        background-color: #d1fae5; /* light green bg */
    }
</style>
    <body class=" text-[#1b1b18]">

    <div class="flex justify-center bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-700 shadow-lg">
        <h1 class="text-3xl sm:text-4xl text-center p-8 sm:p-10 text-white font-extrabold tracking-wide animate-pulse">
            🗳️ CAST YOUR VOTES
        </h1>
    </div>


    <div class="flex justify-center items-start py-10 px-4">
        <div class="w-full max-w-4xl space-y-8">

            <form id="voteForm" action="{{ route('vote.submit') }}" method="POST">
                @csrf

                @foreach($positions as $position)
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-2 text-gray-800 dark:text-white">{{ $position->name }}</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
                            @foreach($position->candidates as $candidate)
                                <label for="candidate_{{ $candidate->id }}">
                                    <div class="cursor-pointer border-4 border-transparent hover:border-emerald-500 rounded-xl p-4 text-center transition-all bg-white dark:bg-gray-800 shadow-md candidate-box"
                                         onclick="selectCandidate(this, '{{ $position->id }}', '{{ $position->type }}')">
                                        <img src="{{ $candidate->getFirstMediaUrl('candidate_photo') }}" alt="Candidate Photo"
                                             class="w-24 h-24 object-cover rounded-full mx-auto mb-2">
                                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $candidate->name }}
                                        </div>
                                        <input type="{{ $position->type == 'multiple' ? 'checkbox' : 'radio' }}"
                                               name="votes[{{ $position->id }}]{{ $position->type == 'multiple' ? '[]' : '' }}"
                                               id="candidate_{{ $candidate->id }}"
                                               value="{{ $candidate->id }}"
                                               class="hidden">
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach




                <div class="flex justify-center mt-10">
                    <button type="button"
                            onclick="openConfirmation()"
                            class="w-[90%] sm:w-[600px] bg-emerald-500 hover:bg-emerald-600 text-white text-2xl font-bold py-6 px-12 rounded-2xl shadow-xl transition-all duration-300 ease-in-out focus:outline-none focus:ring-4 focus:ring-emerald-300">
                        🗳️ Submit Vote
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

{{--Handle selection--}}
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
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($positions as $position)
        @if($position->type === 'multiple')
        const checkboxes{{ $position->id }} = document.querySelectorAll('.position-{{ $position->id }}');
        const max{{ $position->id }} = {{ $position->max_votes }};

        checkboxes{{ $position->id }}.forEach(box => {
            box.addEventListener('change', () => {
                let checked = [...checkboxes{{ $position->id }}].filter(c => c.checked);
                if (checked.length > max{{ $position->id }}) {
                    box.checked = false;
                    alert('You can only select up to {{ $position->max_votes }} candidate(s) for {{ $position->name }}');
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
        card.addEventListener('click', function () {
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
            const card = document.querySelector(`.candidate-card[data-position="${input.dataset.position}"][data-id="${input.dataset.id}"]`);
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
