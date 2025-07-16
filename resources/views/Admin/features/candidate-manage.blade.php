@extends('Admin.dashboard')


@section('content')
    <div class=" sm:ml-64 min-h-screen">
        <div class="border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

            <div class="text-center font-bold text-2xl flex justify-center">
                <h1>List of All Candidates</h1>
            </div>

            <div class="flex justify-between  w-auto mb-2 ">


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
                <div>
                <a href="{{ route('admin.export.voters') }}"
                   class="inline-flex items-center justify-center gap-2 border border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white font-medium py-2 px-4 rounded transition">
                    Export to Excel
                </a>

                <button onclick="openAddCandidateModal()"
                        class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                    + Add Candidate
                </button>
                </div>

            </div>

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
                                <!-- PHOTO -->
                                <td class="px-6 py-4">
                                    @if ($candidate->hasMedia('candidate_photo'))
                                        <img src="{{ $candidate->getFirstMediaUrl('candidate_photo') }}"
                                             alt="{{ $candidate->name }}"
                                             class="w-12 h-12 object-cover rounded-full mx-auto">
                                    @else
                                        <span class="text-gray-400 italic">No Photo</span>
                                    @endif
                                </td>

                                <!-- NAME -->
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $candidate->name }}
                                </td>

                                <!-- POSITION -->
                                <td class="px-6 py-4">
                                    {{ $candidate->position }}
                                </td>


                                <!-- ACTIONS -->
                                <td class="px-6 py-4 flex items-center justify-center space-x-2">

                                    <!-- EDIT BUTTON -->
                                    <button
                                        onclick="openEditModal({{ $candidate->id }}, '{{ $candidate->name }}', '{{ $candidate->position }}', '{{ $candidate->party }}')"
                                        class="text-blue-600 hover:text-blue-800 font-semibold">
                                        Edit
                                    </button>


                                    <!-- DELETE FORM -->
                                    <form action="{{ route('admin.candidate.delete', $candidate->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this candidate?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-semibold">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No candidates found.</td>
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

            <!-- Add Candidate Modal -->
            <div id="addCandidateModal"
                 class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm z-50 justify-center items-center">
                <div class="bg-white p-6 rounded shadow-lg max-w-md w-full relative dark:bg-gray-800">
                    <h2 class="text-xl font-bold mb-4 text-center text-emerald-600">Add New Candidate</h2>

                    <form action="{{ route('admin.candidate.add') }}" method="POST" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="mb-3">
                            <label class="block font-medium text-sm text-gray-700 dark:text-white">Name</label>
                            <input type="text" name="name" required
                                   class="w-full mt-1 border border-gray-300 p-2 rounded dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="mb-3">
                            <label class="block font-medium text-sm text-gray-700 dark:text-white">Position</label>
                            <input type="text" name="position" required
                                   class="w-full mt-1 border border-gray-300 p-2 rounded dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-white">Photo
                                (Optional)</label>
                            <input type="file" name="photo"
                                   class="w-full mt-1 border border-gray-300 p-2 rounded dark:bg-gray-700 dark:text-white">
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="closeAddCandidateModal()"
                                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Edit Modal -->
            <div id="editModal"
                 class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm z-50 justify-center items-center">
                <div class="bg-white p-6 rounded shadow-md max-w-md w-full relative">
                    <button onclick="closeEditModal()" class="absolute top-2 right-2 text-xl text-gray-600 hover:text-red-500">
                        &times;
                    </button>

                    <h2 class="text-xl font-semibold mb-4">Edit Candidate</h2>

                    <form id="editCandidateForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-4">
                            <label for="edit_name" class="block mb-1 font-medium">Name</label>
                            <input type="text" name="name" id="edit_name"
                                   class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white"/>
                        </div>

                        <div class="mb-4">
                            <label for="edit_position" class="block mb-1 font-medium">Position</label>
                            <input type="text" name="position" id="edit_position"
                                   class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white"/>
                        </div>



                        <div class="mb-4">
                            <label for="photo" class="block mb-1 font-medium">Update Photo (Optional)</label>
                            <input type="file" name="photo" id="photo"
                                   class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white"/>
                        </div>

                        <button type="submit"
                                class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>


        </div>

        {{--Adding modal--}}
        <script>
            function openAddCandidateModal() {
                document.getElementById('addCandidateModal').classList.remove('hidden');
                document.getElementById('addCandidateModal').classList.add('flex');
            }

            function closeAddCandidateModal() {
                document.getElementById('addCandidateModal').classList.add('hidden');
                document.getElementById('addCandidateModal').classList.remove('flex');
            }
        </script>

        {{--editing modal--}}
        <script>
            function openEditModal(id, name, position, party) {
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_position').value = position;

                // Set the form action dynamically
                document.getElementById('editCandidateForm').action =
                    `/admin/candidates/${id}`;

                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('flex');
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.getElementById('editModal').classList.remove('flex');
            }
        </script>

@endsection

