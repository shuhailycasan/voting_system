<!-- Add position Modal -->
<div id="addPositionModal"
     class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm z-50 justify-center items-center">
    <div class="bg-white p-6 rounded shadow-lg max-w-md w-full relative dark:bg-gray-800">
        <h2 class="text-xl font-bold mb-4 text-center text-emerald-600">Add New Position</h2>

        <form action="{{ route('admin.position.add') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf

            <div class="mb-3">
                <label class="block font-medium text-sm text-gray-700 dark:text-white">Position Name</label>
                <input type="text" name="name" required
                       class="w-full mt-1 border border-gray-300 p-2 rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div class="mb-3">
                <label class="block font-medium text-sm text-gray-700 dark:text-white">Type</label>
                <select name="type" required class="w-full mt-1 border border-gray-300 p-2 rounded dark:bg-gray-700 dark:text-white">
                    <option value="single">Single</option>
                    <option value="multiple">Multiple</option>
                </select>
            </div>


            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeAddPositionModal()"
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
    function openAddPositionModal() {
        document.getElementById('addPositionModal').classList.remove('hidden');
        document.getElementById('addPositionModal').classList.add('flex');
    }

    function closeAddPositionModal() {
        document.getElementById('addPositionModal').classList.add('hidden');
        document.getElementById('addPositionModal').classList.remove('flex');
    }
</script>
