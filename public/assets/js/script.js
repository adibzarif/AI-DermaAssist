document.addEventListener('DOMContentLoaded', async () => {

    console.log('app loaded');

    const video = document.getElementById("video");
    const circle = document.querySelector(".face-circle");

    window.faceAligned = false;

    // ================= CAMERA =================
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
    } catch (err) {
        alert("Camera access denied");
        console.error(err);
        return;
    }

    // ================= LOAD FACE MODEL =================
    await faceapi.nets.tinyFaceDetector.loadFromUri("/models");
    console.log("Face model loaded");

    // ================= FACE DETECTION LOOP =================
    setInterval(async () => {

        const detection = await faceapi.detectSingleFace(
            video,
            new faceapi.TinyFaceDetectorOptions()
        );

        if (!detection) {
            circle.style.border = "3px solid red";
            window.faceAligned = false;
            return;
        }

        const box = detection.box;

        // Face center
        const faceX = box.x + box.width / 2;
        const faceY = box.y + box.height / 2;

        // Circle position (relative to screen)
        const rect = circle.getBoundingClientRect();

        const circleX = rect.left + rect.width / 2;
        const circleY = rect.top + rect.height / 2;

        // Check alignment (tweak this value if needed)
        const isInside =
            Math.abs(faceX - circleX) < 100 &&
            Math.abs(faceY - circleY) < 100;

        if (isInside) {
            circle.style.border = "3px solid lime";
            window.faceAligned = true;
        } else {
            circle.style.border = "3px solid red";
            window.faceAligned = false;
        }

    }, 200);


    // ================= CAPTURE FUNCTION =================
    window.captureImage = function () {

        if (!window.faceAligned) {
            alert("Please align your face inside the circle");
            return;
        }

        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");

        const size = Math.min(video.videoWidth, video.videoHeight);

        canvas.width = size;
        canvas.height = size;

        // Circle mask
        context.beginPath();
        context.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
        context.closePath();
        context.clip();

        // Crop center
        context.drawImage(
            video,
            (video.videoWidth - size) / 2,
            (video.videoHeight - size) / 2,
            size,
            size,
            0,
            0,
            size,
            size
        );

        canvas.toBlob(async (blob) => {

            const formData = new FormData();
            formData.append("image", blob, "face-circle.png");

            try {
                const res = await fetch("analyze.php", {
                    method: "POST",
                    body: formData
                });

                const result = await res.text();
                document.body.innerHTML = result;

            } catch (err) {
                alert("Upload failed");
                console.error(err);
            }

        }, "image/png");

        
    };

    
    //window.addEventListener("scroll", () => {
    //const navbar = document.querySelector(".topbar");
   // navbar.classList.toggle("active", window.scrollY > 50);
});

