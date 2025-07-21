@extends('Admin.dashboard')


@section('content')
    <div class="min-h-screen  sm:ml-45">
        <div class="container bg-white side m-4 rounded-xl p-3 ">
            <div class="py-6">
                <h1 class="text-3xl font-semibold text-center text-gray-800 dark:text-white border-b-4 border-emerald-500 inline-block px-4 pb-2">
                    Dashboard
                </h1>
            </div>

            <div class="grid grid-cols-1 border-t border-gray-100 gap-4 mt-6 mb-3 shadow-lg md:grid-cols-2 lg:grid-cols-3">
                @foreach($groupedCandidates as $position => $candidates)
                    @php
                        $topCandidates = $candidates->sortByDesc('votes_count')->take(3);
                    @endphp

                    <div class="p-4 bg-white rounded shadow dark:bg-gray-800">
                        <h2 class="font-semibold text-center text-md text-emerald-600">{{ $position }}</h2>
                        <canvas id="chart-{{ \Str::slug($position) }}"></canvas>
                    </div>
                @endforeach
            </div>


            <div class="grid w-full grid-cols-1 gap-6 mt-8 mb-6 border border-gray-200 md:grid-cols-2">
                <div class="p-6 bg-white rounded shadow-lg dark:bg-gray-800">
                    <h2 class="mb-4 text-xl font-bold text-emerald-700 dark:text-emerald-400">INSIGHT</h2>

                    <div class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-3">
                        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Voter Participation</h2>
                            <canvas id="voterParticipationChart" height="200"></canvas>

                            <div class="mt-4 text-center">
                        <span id="voterParticipationRate" class="text-2xl font-bold text-emerald-600">
                            {{-- This gets updated dynamically --}}
                        </span>
                            </div>
                        </div>


                        <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Voting Activity Over
                                Time</h2>
                            <canvas id="votingTrendChart" height="150"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach($groupedCandidates as $position => $candidates)
                const ctx_{{ Str::slug($position, '_') }} = document.getElementById('chart-{{ \Str::slug($position) }}');
                if (ctx_{{ Str::slug($position, '_') }}) {
                    new Chart(ctx_{{ Str::slug($position, '_') }}, {
                        type: 'bar',
                        data: {
                            labels: @json($candidates->sortByDesc('votes_count')->take(3)->pluck('name')),
                            datasets: [{
                                label: 'Votes for {{ $position }}',
                                data: @json($candidates->sortByDesc('votes_count')->take(3)->pluck('votes_count')),
                                backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32'],
                                borderRadius: 8,
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            plugins: {
                                legend: {display: false},
                                title: {
                                    display: true,
                                    text: '{{ $position }} Top Candidates'
                                }
                            },
                            scales: {
                                x: {beginAtZero: true}
                            }
                        }
                    });
                }
                @endforeach
            });
        </script>
    @endpush

    {{--   VOTERS PARTICIPATION CHARTS --}}
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

    {{--    <script>--}}
    {{--        document.addEventListener('DOMContentLoaded', function () {--}}
    {{--            new Chart(document.getElementById('chart-{{ \Str::slug($position) }}'), {--}}
    {{--                type: 'bar',--}}
    {{--                data: {--}}
    {{--                    labels: {!! $labels->toJson() !!},--}}
    {{--                    datasets: [{--}}
    {{--                        label: 'Votes',--}}
    {{--                        data: {!! $votes->toJson() !!},--}}
    {{--                        backgroundColor: ['#FFD700', '#C0C0C0', '#CD7F32'] // gold, silver, bronze--}}
    {{--                        borderRadius: 8,--}}
    {{--                    }]--}}
    {{--                },--}}
    {{--                options: {--}}
    {{--                    indexAxis: 'y', // Horizontal bars--}}
    {{--                    responsive: true,--}}
    {{--                    plugins: {--}}
    {{--                        legend: {display: false},--}}
    {{--                        title: {--}}
    {{--                            display: true,--}}
    {{--                            text: '{{ $position }} Top 3'--}}
    {{--                        }--}}
    {{--                    },--}}
    {{--                    scales: {--}}
    {{--                        x: {beginAtZero: true}--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}


    {{--   VOTERS TREND CHARTS --}}
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
