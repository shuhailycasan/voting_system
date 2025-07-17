@extends('Admin.dashboard')


@section('content')
    <div class="min-h-screen px-4 py-6 transition-all duration-300 lg:ml-64">
        <div class="text-center font-bold text-xl sm:text-2xl py-4">
            <h1>List of All Candidates</h1>
        </div>

        <!-- Search + Buttons -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-4 px-4">
            <!-- Search Form -->
            <form action="{{ route('admin.candidate.table') }}" method="GET" class="flex w-full lg:w-auto">
                @csrf
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search name or position..."
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"/>
                <button type="submit"
                        class="bg-emerald-600 text-white px-4 rounded-r-md hover:bg-emerald-700">
                    Search
                </button>
            </form>

            <!-- Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('admin.export.voters') }}"
                   class="inline-flex items-center justify-center gap-2 border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-medium py-2 px-4 rounded transition">
                    Export to Excel
                </a>

                <button onclick="openAddCandidateModal()"
                        class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                    + Add Candidate
                </button>
                <button onclick="openAddPositionModal()"
                        class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                    + Add Position
                </button>
            </div>
        </div>

        <!-- Table for Candidates -->
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-center">
                        <th class="px-6 py-3">Photo</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Position</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @forelse($candidatesAll as $candidate)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                @if ($candidate->hasMedia('candidate_photo'))
                                    <img src="{{ $candidate->getFirstMediaUrl('candidate_photo') }}"
                                         alt="{{ $candidate->name }}"
                                         class="w-12 h-12 object-cover rounded-full mx-auto">
                                @else
                                    <span class="text-gray-400 italic">No Photo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $candidate->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $candidate->position }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center space-x-2">
                                    <button
                                        onclick="openEditModal({{ $candidate->id }}, '{{ $candidate->name }}', '{{ $candidate->position }}', '{{ $candidate->party }}')"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.candidate.delete', $candidate->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this candidate?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-semibold">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No candidates found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="mt-4 px-4">
                    {{ $candidatesAll->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>

        <!-- Table for Positions -->
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-center">
                        <th class="px-6 py-3">Position Name</th>
                        <th class="px-6 py-3">Position Type</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @forelse($positionAll as $positions)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $positions->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $positions->type }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center space-x-2">
                                    <button
                                        onclick="openEditModal({{ $positions->id }}, '{{ $positions->name }}', '{{ $positions->type }}')"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.candidate.delete', $positions->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this position?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-semibold">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No Position found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="mt-4 px-4">
                    {{ $candidatesAll->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>

        <!--MODALS-->
        @include('Admin.Modals.add-position')
        @include('Admin.Modals.add-candidate')
        @include('Admin.Modals.delete-candidate')
    </div>

@endsection

