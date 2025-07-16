@extends('Admin.dashboard')


@section('content')
    <div class=" border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 sm:m-64 min-h-screen">
        <div class="rounded-sm bg-gray-50 dark:bg-gray-800 p-4">

            <div class="text-center font-bold text-2xl flex justify-center">
                <h1>List of All Users</h1>
            </div>

            <div class="flex justify-between items-center w-auto mb-2">
                <form action="{{ route('admin.candidate.users') }}" method="GET" class="flex ">
                    @csrf
                    <input type="text" name="search_users" value="{{ request('search') }}"
                           placeholder="Search name or position..."
                           class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2
                               focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"/>

                    <button type="submit"
                            class="bg-emerald-600 text-white px-4 rounded-r-md hover:bg-emerald-700">
                        Search
                    </button>

                </form>

                <div class="flex items-center  ">
                    <a href="{{ route('admin.export.voters') }}"
                       class="inline-flex items-center justify-center gap-2 border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-medium py-2 px-4 rounded transition">
                        Export to Excel
                    </a>
                    <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                            class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                        Import Voters
                    </button>

                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-[700px] w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
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
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $userAll->code }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    @if ($userAll->voted)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Yes</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">No</span>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
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
                                <td class="px-6 py-4">
                                    {{ $userAll->role }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No voters found!
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                <div id="photoModal"
                     class="fixed inset-0 backdrop-blur-sm bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="bg-white p-4 rounded shadow-lg max-w-md w-full">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-lg font-semibold">Voter Photo</h2>
                            <button onclick="closePhotoModal()"
                                    class="text-gray-600 hover:text-red-600 text-xl">
                                &times;
                            </button>
                        </div>
                        <img id="modalImage" src="" alt="Voter Photo" class="w-full h-auto rounded">
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $usersAll->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL FOR IMPORTING FILES --}}
        <div id="importModal"
             class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <button onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-lg font-bold">&times;</button>

                <h2 class="text-lg font-semibold mb-4 text-center text-emerald-600">Import Voter Codes</h2>

                <form action="{{ route('admin.import.voters') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="file" name="voters_file"
                           class="block w-full text-sm text-gray-700
                          file:mr-4 file:py-2 file:px-4 file:rounded file:border-0
                          file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700
                          hover:file:bg-emerald-100" required>

                    <div class="flex justify-end space-x-2">
                        <button type="button"
                                onclick="document.getElementById('importModal').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                            Import
                        </button>
                    </div>
                </form>
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
