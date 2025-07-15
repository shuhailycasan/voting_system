@extends('Admin.dashboard')

@section('content')
    <div class="p-4 sm:ml-64">
        <h1 class="text-2xl font-bold mb-6 text-center">Candidate Rankings</h1>

        @foreach($groupedRankings as $position => $candidates)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-2">{{ $position }}</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 bg-white shadow rounded">
                        <thead class="bg-emerald-600 text-white">
                        <tr>
                            <th class="px-6 py-3">Rank</th>
                            <th class="px-6 py-3">Candidate</th>
                            <th class="px-6 py-3">Votes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($candidates as $index => $candidate)
                            <tr class="border-b">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $candidate->name }}</td>
                                <td class="px-6 py-4">{{ $candidate->votes_count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection


