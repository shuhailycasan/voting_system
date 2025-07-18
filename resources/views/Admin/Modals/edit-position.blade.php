<div id="editModalPosition"
     class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm z-50 justify-center items-center">
    <div class="bg-white p-6 rounded shadow-md max-w-md w-full relative">
        <button onclick="closeEditPositionModal()" class="absolute top-2 right-2 text-xl text-gray-600 hover:text-red-500">
            &times;
        </button>

        <h2 class="text-xl font-semibold mb-4">Edit Position</h2>

        <form id="editPositionForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <div class="mb-4">
                <label for="edit_name" class="block mb-1 font-medium">Position Name</label>
                <input type="text" name="name" id="edit_name"
                       class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white"/>
            </div>

            <div class="mb-4">
                <label for="edit_type" class="block mb-1 font-medium">Position Type</label>
                <select name="type" id="edit_type"
                        class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
                    <option value="single">Single</option>
                    <option value="multiple">Multiple</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="edit_max_votes" class="block mb-1 font-medium">Max Votes</label>
                <input type="number" name="max_votes" id="edit_max_votes" min="1"
                       class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white"/>
            </div>

            <button type="submit"
                    class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700">
                Save Changes
            </button>
        </form>
    </div>
</div>


{{--editing modal--}}
<script>
    function openEditPositionModal(id, name, type, maxVotes) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_type').value = type;
        document.getElementById('edit_max_votes').value = maxVotes;

        // Set correct form action
        document.getElementById('editPositionForm').action = `/admin/positions/${id}`;

        // Show modal
        const modal = document.getElementById('editModalPosition');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditPositionModal() {
        const modal = document.getElementById('editModalPosition');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

