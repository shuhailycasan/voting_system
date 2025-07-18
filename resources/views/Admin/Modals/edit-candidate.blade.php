<div id="editModal"
     class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm z-50 justify-center items-center">
    <div class="bg-white p-6 rounded shadow-md max-w-md w-full relative">
        <button onclick="closeEditModal()" class="absolute top-2 right-2 text-xl text-gray-600 hover:text-red-500">
            &times;
        </button>

        <h2 class="text-xl font-semibold mb-4">Edit Candidate</h2>

        <form  id="editCandidateForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <div class="mb-4">
                <label for="edit_name" class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="edit_name"
                       class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white"/>
            </div>

            <div class="mb-4">
                <label for="edit_position" class="block mb-1 font-medium">Position Name</label>
                <select name="position_id" id="edit_position" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-white">
                    @foreach ($positionsAll as $position)
                        <option value="{{ $position->id }}"  >{{ $position->name }}</option>
                    @endforeach
                </select>
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

{{--editing modal--}}
<script>
    function openEditModal(id, name, positionId) {
        console.log('Editing candidate:', { id, name, positionId });

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_position').value = positionId;


        // Set the form action
        document.getElementById('editCandidateForm').action = `/admin/candidates/${id}`;

        // Show modal
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>
