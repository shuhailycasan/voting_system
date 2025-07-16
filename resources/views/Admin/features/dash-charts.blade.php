@extends('Admin.dashboard')


@section('content')
    <div class=" sm:ml-45 min-h-screen">

        <h1 class="text-2xl font-bold text-center text-emerald-700 dark:text-emerald-400 m-2">Candidates Chart</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 mb-3">
            @foreach($groupedCandidates as $position => $candidates)
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                    <h2 class="text-md font-semibold text-center text-emerald-600">{{ $position }}</h2>
                    <ul class="mt-2 space-y-1">
                        @foreach($candidates->sortByDesc('votes_count')->take(3) as $candidate)
                            <li class="text-sm font-medium text-gray-800 dark:text-white">
                                🥇 {{ $candidate->name }} - {{ $candidate->votes_count }} votes
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 w-full mb-6 border border-gray-200">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold text-emerald-700 dark:text-emerald-400 mb-4">INSIGHT</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Total Voters</h2>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $totalVoters }}</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Voted</h2>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $votedCount }}</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Not Voted</h2>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $notVotedUsers }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Total Candidates</h2>
                        <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $totalCandidates }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($groupedCandidates as $position => $candidates)
                <div
                    class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold mb-4 text-center text-gray-800 dark:text-gray-100">{{ $position }}</h2>
                    <canvas id="chart-{{ Str::slug($position) }}" class="w-full h-64"></canvas>
                </div>
            @endforeach
        </div>





    </div>

    @php
        $colors = [
            'President' => 'rgba(255, 99, 132, 0.6)', // Red
            'Vice President' => 'rgba(54, 162, 235, 0.6)', // Blue
            'Secretary' => 'rgba(255, 206, 86, 0.6)', // Yellow
            'Treasurer' => 'rgba(75, 192, 192, 0.6)', // Teal
        ];
    @endphp

    <script>
        const colors = @json($colors);

        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($groupedCandidates as $position => $candidates)
            const ctx_{{ Str::slug($position, '_') }} = document.getElementById('chart-{{ Str::slug($position) }}')?.getContext('2d');

            if (ctx_{{ Str::slug($position, '_') }}) {
                new Chart(ctx_{{ Str::slug($position, '_') }}, {
                    type: 'bar',
                    data: {
                        labels: @json($candidates->pluck('name')),
                        datasets: [{
                            label: 'Votes for {{ $position }}',
                            data: @json($candidates->pluck('votes_count')),
                            backgroundColor: colors["{{ $position }}"] ?? 'rgba(16, 185, 129, 0.6)',
                            borderColor: 'rgba(5, 150, 105, 1)',
                            borderWidth: 1,
                            borderRadius: 5,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
            @endforeach
        });
    </script>

@endsection
