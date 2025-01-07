const voiceInputButton = document.getElementById('voiceInputButton');
const searchInput = document.getElementById('search');
let mediaRecorder;
let audioChunks = [];

async function voiceSearch(apiKey) {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        console.log("Your browser does not support audio recording.");
        return;
    }

    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);

        mediaRecorder.start();
        audioChunks = [];
        voiceInputButton.innerHTML = '<i class="fa-solid fa-stop"></i>';

        mediaRecorder.ondataavailable = (event) => {
            audioChunks.push(event.data);
        };

        mediaRecorder.onstop = async () => {
            voiceInputButton.innerHTML = '<i class="fa-solid fa-microphone"></i>';
            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });

            const response = await fetch("https://api.deepgram.com/v1/listen", {
                method: "POST",
                headers: {
                    "Authorization": "Token " + apiKey,
                    "Content-Type": "audio/webm",
                    "Accept": "application/json"
                },
                body: audioBlob
            });

            const result = await response.json();
            if (result.results && result.results.channels[0].alternatives[0].transcript) {
                searchInput.value = result.results.channels[0].alternatives[0].transcript;
                document.getElementById("searchForm").submit();
            } else {
                console.log("No speech detected. Please try again.");
            }
        };

        setTimeout(() => mediaRecorder.stop(), 5000);
        voiceInputButton.onclick = () => mediaRecorder.stop();

    } catch (err) {
        console.error("Error accessing microphone:", err);
        console.log("Could not access the microphone. Please check your permissions.");
    }
}