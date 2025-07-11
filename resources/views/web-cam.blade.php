<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
<body class="bg-[#FDFDFC] text-[#1b1b18]">
    <div class="flex justify-center items-center h-screen">
        <div class="flex flex-col bg-white shadow p-10 rounded-lg">
            <h1 class="text-2xl text-center font-bold mb-4">Take a Picture</h1>
            <video id="webcam" autoplay playsinline class="mx-auto mb-4 rounded shadow w-full max-w-md"></video>
            <canvas id="snapshot" style="display: none;"></canvas>
            <button id="takePhoto"
                    class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition">
                Take Photo
            </button>
        </div>
    </div>
</body>

<script>

    const video = document.getElementById("webcam");

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => {
            console.error("Camera access failed:", err);
            alert("Unable to access camera. Please allow permission.");
        });

    document.getElementById("takePhoto").addEventListener("click", function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const canvas = document.getElementById("snapshot");
        const ctx = canvas.getContext("2d");

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0);

        canvas.toBlob(function (blob) {
            const formData = new FormData();
            formData.append("photo", blob, "photo.jpg");

            fetch("/vote/photo", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                body: formData
            })
                .then(res => {
                    if (!res.ok) throw new Error("Upload failed");
                    return res.text(); // or res.json() if your controller returns JSON
                })
                .then(() => {
                    window.location.href = '/thank-you';
                })
                .catch(err => {
                    console.error("Upload error:", err);
                    alert("Photo upload failed.");
                });
        }, "image/jpeg");
    });
</script>
