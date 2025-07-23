@extends('Admin.dashboard')

@section('content')
    <div class="min-h-screen p-4 sm:ml-64">
        <div class="container border-1 border-gray-200 bg-white side mb-4 rounded-xl p-3">
                <div class="flex justify-between items-center py-2 space-x-2 ">
                    <h1 class="text-3xl font-semibold text-center text-gray-800 dark:text-white border-b-4 border-emerald-500 inline-block px-4 pb-2">
                        Rankings
                    </h1>
                    <a href="{{ route('admin.export.rankings') }}"
                       class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                        Export Voters
                    </a>
                </div>

            <div class="grid grid-cols-1  gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($groupedRankings as $position => $candidates)
                    <div class="p-6 bg-white border-t border-gray-100 rounded-lg shadow-lg dark:bg-gray-800">
                        <h2 class="mb-4 text-xl font-semibold text-center text-emerald-600 dark:text-white">
                            {{ $position }}
                        </h2>

                        <ol class="space-y-2">
                            @forelse ($candidates as $candidate)
                                @php
                                    $rank = $loop->index;
                                    $colors = ['bg-yellow-300', 'bg-gray-300', 'bg-orange-300']; // 1st, 2nd, 3rd
                                    $bg = $colors[$rank] ?? 'bg-gray-100 dark:bg-gray-700';
                                @endphp

                                <li class="flex items-center space-x-4 p-4 rounded {{ $bg }}">
                                    {{-- Profile Picture --}}
                                    <div class="flex-shrink-0">
                                        @if ($candidate->hasMedia('candidate_photo'))
                                            <img src="{{ $candidate->getFirstMediaUrl('candidate_photo') }}"
                                                 alt="{{ $candidate->name }}"
                                                 class="object-cover w-12 h-12 border-2 border-white rounded-full shadow"/>
                                        @else
                                            <div
                                                class="flex items-center justify-center w-12 h-12 text-sm font-bold text-white bg-gray-300 rounded-full">
                                                ?
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Candidate Info --}}
                                    <div class="flex items-center justify-between border border-emerald-400">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                            {{ $candidate->name }}
                                        </h3>
                                        <p class="text-3xl font-bold text-gray-600 dark:text-gray-300">
                                            {{ $candidate->votes_count }} votes
                                        </p>
                                    </div>

                                </li>
                            @empty
                                <li class="text-sm text-center text-gray-400">No candidates</li>
                            @endforelse
                        </ol>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
