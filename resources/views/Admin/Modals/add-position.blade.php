<!-- Add position Modal -->
<div id="addPositionModal" class="fixed inset-0 z-50 items-center justify-center hidden bg-black/40 backdrop-blur-sm">
    <div class="relative w-full max-w-md p-6 bg-white rounded shadow-lg dark:bg-gray-800">
        <h2 class="mb-4 text-xl font-bold text-center text-emerald-600">Add New Position</h2>

        @if (session('success'))
            <div class="p-2 text-green-800 bg-green-200 rounded">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="p-2 text-red-800 bg-red-200 rounded">{{ session('error') }}</div>
        @endif
        <form action="{{ route('admin.position.add') }}" method="POST" enctype="multipart/form-data">
            @method('POST')
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Position Name</label>
                <input type="text" name="name" required
                    class="w-full p-2 mt-1 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 dark:text-white">Type</label>
                <select name="type" required
                    class="w-full p-2 mt-1 border border-gray-300 rounded dark:bg-gray-700 dark:text-white">
                    <option value="single">Single</option>
                    <option value="multiple">Multiple</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Max Votes</label>
                <input type="number" name="max_votes" min="1"
                    class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Order</label>
                <input type="number" name="order" min="1"
                    class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white" />
            </div>


            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeAddPositionModal()"
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
    function openAddPositionModal() {
        document.getElementById('addPositionModal').classList.remove('hidden');
        document.getElementById('addPositionModal').classList.add('flex');
    }

    function closeAddPositionModal() {
        document.getElementById('addPositionModal').classList.add('hidden');
        document.getElementById('addPositionModal').classList.remove('flex');
    }
</script>
