<div id="imageModal"
     class="fixed inset-0 z-50 hidden items-center justify-center backdrop-blur-md">
    <div class="relative p-4 bg-white rounded-lg shadow-lg max-w-lg w-full">
        <button onclick="closeImageModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">X</button>
        <img id="modalImage" src="" alt="Candidate Photo" class="w-full h-auto rounded">
    </div>
</div>

<script>
    function showImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        img.src = imageUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<script>
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape") {
            closeImageModal();
        }
    });
</script>
