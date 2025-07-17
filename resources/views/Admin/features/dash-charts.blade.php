@extends('Admin.dashboard')


@section('content')
    <div class=" sm:ml-45 min-h-screen">

        <h1 class="text-2xl font-bold text-center text-emerald-700 dark:text-emerald-400 m-2">Candidates Chart</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 mb-3">
            @foreach($groupedCandidates as $position => $candidates)
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                    <h2 class="text-md font-semibold text-center text-emerald-600">{{ $position }}</h2>

                    <canvas id="chart-{{ \Str::slug($position) }}"></canvas>

                    @php
                        $topCandidates = $candidates->sortByDesc('votes_count')->take(3);
                        $labels = $topCandidates->pluck('name');
                        $votes = $topCandidates->pluck('votes_count');
                    @endphp
                </div>
            @endforeach
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 w-full mb-6 border border-gray-200">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold text-emerald-700 dark:text-emerald-400 mb-4">INSIGHT</h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Voter Participation</h2>
                        <canvas id="voterParticipationChart" height="200"></canvas>

                        <div class="mt-4 text-center">
                        <span id="voterParticipationRate" class="text-2xl font-bold text-emerald-600">
                            {{-- This gets updated dynamically --}}
                        </span>
                        </div>
                    </div>


                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Voting Activity Over Time</h2>
                        <canvas id="votingTrendChart" height="150"></canvas>
                    </div>

                </div>
            </div>
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
                        // indexAxis: 'y',
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const voted = {{ $votedCount }};
            const notVoted = {{ $notVotedUsers }};
            const total = voted + notVoted;
            const percentage = ((voted / total) * 100).toFixed(1);

            // Show % with icon
            const indicator = percentage >= 70
                ? `<span class="text-emerald-500">▲ ${percentage}%</span>`
                : `<span class="text-red-500">▼ ${percentage}%</span>`;

            document.getElementById('voterParticipationRate').innerHTML = indicator;

            const ctx = document.getElementById('voterParticipationChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Voted', 'Not Voted'],
                    datasets: [{
                        data: [voted, notVoted],
                        backgroundColor: ['#10b981', '#f87171'],
                        borderColor: '#1f2937',
                        borderWidth: 2
                    }]
                },
                options: {
                    cutout: '70%',
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#6b7280'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let value = context.raw;
                                    return `${context.label}: ${value} (${((value / total) * 100).toFixed(1)}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Chart(document.getElementById('chart-{{ \Str::slug($position) }}'), {
                type: 'bar',
                data: {
                    labels: {!! $labels->toJson() !!},
                    datasets: [{
                        label: 'Votes',
                        data: {!! $votes->toJson() !!},
                        backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32'] // gold, silver, bronze
                        borderRadius: 8,
                    }]
                },
                options: {
                    indexAxis: 'y', // Horizontal bars
                    responsive: true,
                    plugins: {
                        legend: {display: false},
                        title: {
                            display: true,
                            text: '{{ $position }} Top 3'
                        }
                    },
                    scales: {
                        x: {beginAtZero: true}
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const timeLabels = {!! json_encode(array_keys($votesByHour->toArray())) !!};
            const voteCounts = {!! json_encode(array_values($votesByHour->toArray())) !!};

            const ctx = document.getElementById("votingTrendChart").getContext("2d");

            new Chart(ctx, {
                type: "line", // or "bar" if you want bars instead
                data: {
                    labels: timeLabels,
                    datasets: [{
                        label: "Votes per Hour",
                        data: voteCounts,
                        borderColor: "#10B981",
                        backgroundColor: "rgba(16, 185, 129, 0.2)",
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: "#10B981",
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Time',
                                color: '#6B7280'
                            },
                            ticks: {
                                color: '#6B7280'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Votes',
                                color: '#6B7280'
                            },
                            ticks: {
                                color: '#6B7280'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#6B7280'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => `${ctx.parsed.y} votes`
                            }
                        }
                    }
                }
            });
        });
    </script>



@endsection
