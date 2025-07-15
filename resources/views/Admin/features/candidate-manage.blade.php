@extends('Admin.dashboard')


@section('content')
    <div class="flex justify-center border border-emerald-400 sm:ml-64 min-h-screen">
        <div class="border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            <div class="mb-4 rounded-sm bg-gray-50 dark:bg-gray-800 p-4">
                <div class="flex flex-col lg:flex justify-between items-center pb-2">
                    <div class="text-center font-bold text-2xl flex justify-center">
                        <h1>List of All Candidates</h1>
                    </div>

                    <form action="{{ route('admin.candidate.table') }}" method="GET" class="flex">
                        @csrf
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search name or position..."
                               class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2
                               focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"/>


                        <button type="submit"
                                class="bg-emerald-600 text-white px-4 rounded-r-md hover:bg-emerald-700">
                            Search
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr class="text-center">
                            <th scope="col" class="px-6 py-3">Candidate Name</th>
                            <th scope="col" class="px-6 py-3">Position</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @forelse ($candidatesAll as $candidateAll)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $candidateAll->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $candidateAll->position }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No candidates</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $candidatesAll->appends(['search' => request('search')])->links() }}
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                {{-- Add Candidate --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Add New Candidate</h2>

                    @if (session('success'))
                        <div class="mb-4 text-green-600 font-medium">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.candidate.add') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Name</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"/>
                        </div>

                        <div class="mb-4">
                            <label for="position"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Position</label>
                            <input type="text" id="position" name="position" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"/>
                        </div>

                        <button type="submit"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-md">
                            Add Candidate
                        </button>
                    </form>
                </div>

                {{-- Delete Candidate --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
                    <h2 class="text-xl font-bold text-red-700 dark:text-red-400 mb-4">Delete Candidate</h2>

                    @if (session('deleted'))
                        <div class="mb-4 text-red-600 font-medium">
                            {{ session('deleted') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.candidate.delete', $candidateAll->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <label for="candidate_id"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Select
                                Candidate</label>
                            <select name="candidate_id" id="candidate_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                @foreach ($candidatesAll as $candidate)
                                    <option value="{{ $candidate->id }}">{{ $candidate->name }}
                                        - {{ $candidate->position }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md">
                            Delete Candidate
                        </button>
                    </form>

                </div>
            </div>
        </div>
@endsection
