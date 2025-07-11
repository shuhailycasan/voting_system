@extends('Admin.dashboard')


@section('content')
<div class="p-4 flex justify-center border border-emerald-400 sm:ml-64 min-h-screen">
    <div class="w-full max-w-4xl p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="  mb-4 rounded-sm bg-gray-50 dark:bg-gray-800 p-4">

            <div class="flex flex-col lg:flex justify-between items-center pb-2">
                <div class="text-center font-bold text-2xl flex justify-center">
                    <h1>List of All Users</h1>
                </div>

                <form action="{{ route('admin.candidate.table') }}" method="GET" class="flex">
                    @csrf
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search name or position..."
                           class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2
                               focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" />


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
                        <th scope="col" class="px-6 py-3">Voter Codes</th>
                        <th scope="col" class="px-6 py-3">Has Voted?</th>
                        <th scope="col" class="px-6 py-3">Time Voted</th>
                        <th scope="col" class="px-6 py-3">Picture</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @forelse ($usersAll as $userAll)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $userAll->code }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                @if ($userAll->voted)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Yes</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">No</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                {{ $userAll->voted_at }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                @if ($userAll->hasMedia('vote_photo'))
                                    <button
                                        type="button"
                                        data-photo-url="{{ $userAll->getFirstMediaUrl('vote_photo') }}"
                                        onclick="openPhotoModal(this)"
                                        class="text-emerald-600 hover:text-emerald-800 text-center"
                                    >
                                        <!-- Camera SVG Icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 7h2l1-2h12l1 2h2v12H3V7z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 13a3 3 0 100-6 3 3 0 000 6z" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-gray-400">No Photo</span>
                                @endif

                            </td>
                            <td class="px-6 py-4">
                                {{ $userAll->role }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">No voters found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div id="photoModal" class="fixed inset-0 backdrop-blur-sm bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="bg-white p-4 rounded shadow-lg max-w-md w-full">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-semibold">Voter Photo</h2>
                            <button onclick="closePhotoModal()" class="text-gray-600 hover:text-red-600 text-xl">&times;</button>
                        </div>
                        <img id="modalImage" src="" alt="Voter Photo" class="w-full h-auto rounded">
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $usersAll->appends(['search' => request('search')])->links() }}
                </div>
            </div>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 w-full">

                {{-- Delete Candidate --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
                    <h2 class="text-xl font-bold text-red-700 dark:text-red-400 mb-4">Delete Candidate</h2>

                    @if (session('deleted'))
                        <div class="mb-4 text-red-600 font-medium">
                            {{ session('deleted') }}
                        </div>
                    @endif

                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <label for="candidate_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Select Candidate</label>
                            <select name="candidate_id" id="candidate_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">

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
    </div>
</div>

<script>
    function openPhotoModal(button) {
        const photoUrl = button.getAttribute('data-photo-url');
        const modal = document.getElementById('photoModal');
        const img = document.getElementById('modalImage');

        img.src = photoUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        const img = document.getElementById('modalImage');

        img.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection
