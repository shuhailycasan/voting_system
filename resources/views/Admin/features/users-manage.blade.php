@extends('Admin.dashboard')


@section('content')
    <div class="min-h-screen m-4 pt-6 sm:ml-64">
        <div class="bg-white border-1 border-gray-100  rounded-lg dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-800">
            <div class="py-6">
                <h1 class="text-3xl font-semibold text-center text-gray-800 dark:text-white border-b-4 border-emerald-500 inline-block px-4 pb-2">
                    List of Users
                </h1>
            </div>

            {{-- Search + Export/Import --}}
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">
                <form action="{{ route('admin.candidate.users') }}" method="GET" class="flex w-full md:w-auto">
                    @csrf
                    <input type="text" name="search_users" value="{{ request('search') }}"
                           placeholder="Search codes or role..."
                           class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 w-full md:w-auto"/>
                    <button type="submit"
                            class="bg-emerald-600 text-white px-4 rounded-r-md hover:bg-emerald-700">
                        Search
                    </button>
                </form>

                <div class="flex flex-wrap justify-end gap-2">
                    <a href="{{ route('admin.export.voters') }}"
                       class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                        Export Voters
                    </a>
                    <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                            class="inline-flex items-center justify-center gap-2 border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-medium py-2 px-4 rounded transition">
                        Import Codes
                    </button>
                    <form method="POST" action="{{ route('admin.users.generate-code') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-medium py-2 px-4 rounded transition">
                            Generate Code
                        </button>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-[700px] w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase border border-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-center">
                        <th scope="col" class="px-6 py-3 w-40">Voter Codes</th>
                        <th scope="col" class="px-6 py-3 w-40">Has Voted?</th>
                        <th scope="col" class="px-6 py-3 w-40">Time Voted</th>
                        <th scope="col" class="px-6 py-3 w-40">Picture</th>
                        <th scope="col" class="px-6 py-3 w-40">Role</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @forelse ($usersAll as $userAll)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $userAll->code }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                @if ($userAll->voted)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Yes</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $userAll->voted_at }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                @if ($userAll->hasMedia('vote_photo'))
                                    <button type="button"
                                            data-photo-url="{{ $userAll->getFirstMediaUrl('vote_photo') }}"
                                            onclick="openPhotoModal(this)"
                                            class="text-emerald-600 hover:text-emerald-800 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 7h2l1-2h12l1 2h2v12H3V7z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 13a3 3 0 100-6 3 3 0 000 6z"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-400">No Photo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $userAll->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No voters found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $usersAll->appends(['search' => request('search')])->links() }}
            </div>
        </div>

        {{-- PHOTO OPEN MODAL --}}
        @include('Admin.Modals.open-photo')
        {{-- IMPORT VOTER CODES MODAL --}}
        @include('Admin.Modals.import-voter')

    </div>

@endsection
