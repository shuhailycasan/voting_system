@extends('Admin.dashboard')


@section('content')
    <div class="p-4 sm:ml-64">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($groupedCandidates as $position => $candidates)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold mb-4 text-center text-gray-800 dark:text-gray-100">{{ $position }}</h2>
                    <canvas id="chart-{{ Str::slug($position) }}" class="w-full h-64"></canvas>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
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
                            backgroundColor: 'rgba(16, 185, 129, 0.6)',
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
@endpush
