{{-- Photo Modal --}}
<div id="photoModal"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden justify-center items-center z-50">
    <div class="bg-white dark:bg-gray-900 p-4 rounded shadow-lg w-[90%] max-w-md relative">
        <button onclick="closePhotoModal()"
                class="absolute top-2 right-3 text-gray-600 hover:text-red-600 text-xl font-bold">&times;</button>
        <h2 class="text-lg font-semibold mb-4 dark:text-white">Voter Photo</h2>
        <img id="modalImage" src="" alt="Voter Photo" class="w-full h-auto rounded">
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
