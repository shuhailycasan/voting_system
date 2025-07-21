<!-- Add Candidate Modal -->
<div id="addCandidateModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/40 backdrop-blur-sm">
    <div class="relative w-full max-w-md p-6 bg-white rounded shadow-lg dark:bg-gray-800">
        <h2 class="mb-4 text-xl font-bold text-center text-emerald-600">Add New Candidate</h2>

        <form action="{{ route('admin.candidate.add') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Name</label>
                <input type="text" name="name" required
                       class="w-full p-2 mt-1 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div class="mb-3">
                <label for="position_id"
                       class="block text-sm font-medium text-gray-700 dark:text-white">Position</label>
                <select name="position_id" id="position_id" required
                        class="w-full p-2 mt-1 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">
                    <option value="" disabled selected>Select a position</option>
                    @foreach ($positionsAll as $position)
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Photo
                    (Optional)</label>
                <input type="file" name="photo" accept="image/jpeg,image/png" class="form-input"
                       onchange="checkFileSize(this)"
                       class="w-full p-2 mt-1 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeAddCandidateModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-white rounded bg-emerald-600 hover:bg-emerald-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Adding modal --}}
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

{{-- check file size --}}
<script>
    function checkFileSize(input) {
        const file = input.files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            alert("Picture is too large! Max size is 2MB.");
            input.value = ""; // Reset file input
        }
    }
</script>
