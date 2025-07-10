<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="bg-[#FDFDFC] text-[#1b1b18]">
<div class="flex justify-center items-center border border-emerald-500 h-svh">
    <div class="flex flex-col bg-white shadow height-100 p-10">

        <div>
            <h1 class="text-2xl text-center font-bold">Take a Picture</h1>
            <video id="webcam" autoplay playsinline class="mx-auto mb-4 rounded shadow"></video>
            <canvas id="snapshot" style="display:none;"></canvas>
            <button id="takePhoto" class="bg-emerald-600 text-white px-4 py-2 rounded">Take Photo</button>
        </div>

    </div>
</div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('snapshot');
        const takePhotoBtn = document.getElementById('takePhoto');

        // Start the webcam
        navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
            video.srcObject = stream;
        });

        takePhotoBtn.addEventListener('click', () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            canvas.toBlob(function (blob) {
                const formData = new FormData();
                formData.append('photo', blob);

                fetch("{{ route('vote.photo.upload') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        // Redirect to thank you after successful upload
                        if (data.status === 'success') {
                            window.location.href = '{{ route("vote.thankyou") }}';
                        }
                    })
                    .catch(err => {
                        console.error('Upload failed:', err);
                    });
            }, 'image/jpeg');
        });
    });
</script>
