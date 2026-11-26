
document.addEventListener('DOMContentLoaded', function () {

    const pickup = document.getElementById('pickup');
    const destination = document.getElementById('destination');
    const locateBtn = document.getElementById('locateBtn');
    const swapBtn = document.getElementById('swapBtn');


    // =========================
    // TUKAR LOKASI
    // =========================

    if (swapBtn && pickup && destination) {

        swapBtn.addEventListener('click', function () {

            const temp = pickup.value;

            pickup.value = destination.value;
            destination.value = temp;

        });

    }


    // =========================
    // GPS / LOKASI PENGGUNA
    // =========================

    if (locateBtn && pickup) {

        locateBtn.addEventListener('click', function () {

            if (!navigator.geolocation) {
                alert('Browser tidak mendukung fitur lokasi.');
                return;
            }

            locateBtn.disabled = true;
            locateBtn.textContent = '...';

            navigator.geolocation.getCurrentPosition(

                function (position) {

                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    pickup.value = latitude + ', ' + longitude;

                    if (typeof map !== 'undefined') {
                        map.setView([latitude, longitude], 15);
                    }

                    locateBtn.disabled = false;
                    locateBtn.textContent = '⌖';

                },

                function () {

                    alert('Gagal mendapatkan lokasi. Pastikan izin GPS diaktifkan.');

                    locateBtn.disabled = false;
                    locateBtn.textContent = '⌖';

                },

                {
                    enableHighAccuracy: true,
                    timeout: 10000
                }

            );

        });

    }


    // =========================
    // PETA LEAFLET
    // =========================

    if (typeof L !== 'undefined' && document.getElementById('map')) {

        const map = L.map('map').setView(
            [-7.548, 112.235],
            14
        );


        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);


        // MARKER DRIVER SIMULASI

        const drivers = [

            {
                lat: -7.551,
                lng: 112.229,
                name: 'Pak Hendra (4.9 ★)'
            },

            {
                lat: -7.542,
                lng: 112.241,
                name: 'Pak Joko (Innova EV)'
            },

            {
                lat: -7.557,
                lng: 112.246,
                name: 'Ibu Rina (Innova EV)'
            }

        ];


        drivers.forEach(function (driver) {

            L.marker([driver.lat, driver.lng])

                .addTo(map)

                .bindPopup(driver.name);

        });


        // MARKER TITIK JEMPUT SIMULASI

        const pickupMarker = L.marker(
            [-7.548, 112.235]
        ).addTo(map);

        pickupMarker.bindPopup('Titik Jemput');


        // RUTE SIMULASI

        L.polyline(
            [
                [-7.551, 112.229],
                [-7.548, 112.235],
                [-7.542, 112.241]
            ],
            {
                color: '#9bd83b',
                weight: 4
            }
        ).addTo(map);


        // MENCEGAH MAP TIDAK SESUAI UKURAN

        setTimeout(function () {
            map.invalidateSize();
        }, 300);

    }

});
