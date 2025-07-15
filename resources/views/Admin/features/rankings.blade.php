@extends('Admin.dashboard')

@section('content')
    <div class="p-4 sm:ml-64 min-h-screen">
        <h1 class="text-2xl font-bold mb-6 text-center">Candidate Rankings</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($groupedRankings as $position => $candidates)
                <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold mb-4 text-emerald-600 dark:text-white text-center">
                        {{ $position }}
                    </h2>

                    <ol class="space-y-2">
                        @forelse ($candidates as $candidate)
                            @php
                                $rank = $loop->index;
                                $colors = ['bg-yellow-300', 'bg-gray-300', 'bg-orange-300'];
                                $bg = $colors[$rank] ?? 'bg-white';
                            @endphp

                            <div class="shadow p-4 rounded {{ $bg }}">
                                <h3 class="text-lg font-bold">{{ $candidate->name }}</h3>
                                <p class="text-sm text-gray-700">Votes: {{ $candidate->votes_count }}</p>
                            </div>
                        @empty
                            <li class="text-gray-400 text-sm text-center">No candidates</li>
                        @endforelse
                    </ol>
                </div>
            @endforeach
        </div>
    </div>
@endsection
