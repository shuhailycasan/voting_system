{{-- Import Voter Modal --}}
<div id="importModal"
     class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <button onclick="document.getElementById('importModal').classList.add('hidden')"
                class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-lg font-bold">&times;</button>

        <h2 class="text-lg font-semibold mb-4 text-center text-emerald-600 dark:text-white">Import Voter Codes</h2>


        <form action="{{ route('admin.import.voters') }}" method="POST" enctype="multipart/form-data"
              class="space-y-4">
            @csrf

            @if (session('success'))
                <p class="text-red-600">{{ session('success') }}</p>
            @endif
            <input type="file" name="voters_file"
                   class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0
                       file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                   required>

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

