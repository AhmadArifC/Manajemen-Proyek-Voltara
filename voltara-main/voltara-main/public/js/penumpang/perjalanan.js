document.addEventListener("DOMContentLoaded", function () {

    // =====================================================
    // COUNTDOWN WAKTU TUNGGU DRIVER
    // =====================================================

    const countdownElement = document.getElementById("countdown");

    if (countdownElement) {

        const arrivalTime = parseInt(
            countdownElement.dataset.arrivalTime,
            10
        );

        const freeWaitingTime = 5 * 60;

        function updateCountdown() {

            const currentTime = Math.floor(Date.now() / 1000);

            const elapsedTime = currentTime - arrivalTime;

            let remainingTime = freeWaitingTime - elapsedTime;

            if (remainingTime < 0) {
                remainingTime = 0;
            }

            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;

            countdownElement.textContent =
                String(minutes).padStart(2, "0") +
                ":" +
                String(seconds).padStart(2, "0");

            if (remainingTime <= 0) {
                countdownElement.textContent = "00:00";
            }
        }

        updateCountdown();

        setInterval(updateCountdown, 1000);
    }


    // =====================================================
    // PETA LEAFLET
    // =====================================================

    const mapElement = document.getElementById("map");

    if (mapElement && typeof L !== "undefined") {

        const map = L.map("map").setView(
            [-7.548, 112.235],
            14
        );

        L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
            {
                attribution: "&copy; OpenStreetMap"
            }
        ).addTo(map);

        const driverLocation = [-7.548, 112.235];

        L.marker(driverLocation)
            .addTo(map)
            .bindPopup("Driver VOLTARA");

        setTimeout(function () {
            map.invalidateSize();
        }, 300);
    }


    // =====================================================
    // TOMBOL SOS
    // =====================================================

    const sosButton = document.getElementById("sosBtn");

    if (sosButton) {

        sosButton.addEventListener("click", function () {

            alert(
                "Fitur Bantuan SOS akan segera tersedia."
            );

        });

    }


    // =====================================================
    // BAGIKAN RUTE
    // =====================================================

    const shareRouteButton =
        document.getElementById("shareRouteBtn");

    if (shareRouteButton) {

        shareRouteButton.addEventListener(
            "click",
            async function () {

                const shareData = {
                    title: "Perjalanan VOLTARA",
                    text: "Saya sedang dalam perjalanan menggunakan VOLTARA."
                };

                if (navigator.share) {

                    try {
                        await navigator.share(shareData);
                    } catch (error) {
                        console.log("Berbagi dibatalkan.");
                    }

                } else {

                    alert(
                        "Fitur berbagi rute tidak didukung browser ini."
                    );

                }

            }
        );

    }

});