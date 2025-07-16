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
