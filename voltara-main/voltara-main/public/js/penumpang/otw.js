
document.addEventListener('DOMContentLoaded', function () {

    // ==============================
    // PETA PERJALANAN
    // ==============================

    let tripMap = null;

    const mapElement = document.getElementById('tripMap');

    if (typeof L !== 'undefined' && mapElement) {

        tripMap = L.map('tripMap').setView(
            [-7.548, 112.235],
            14
        );

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(tripMap);

        // SIMULASI POSISI DRIVER
        const driverPosition = [-7.551, 112.229];

        // SIMULASI TITIK JEMPUT
        const pickupPosition = [-7.548, 112.235];

        // SIMULASI TITIK TUJUAN
        const destinationPosition = [-7.542, 112.241];

        // MARKER DRIVER
        L.marker(driverPosition)
            .addTo(tripMap)
            .bindPopup('Driver menuju lokasi penumpang');

        // MARKER PENJEMPUTAN
        L.marker(pickupPosition)
            .addTo(tripMap)
            .bindPopup('Titik jemput penumpang');

        // MARKER TUJUAN
        L.marker(destinationPosition)
            .addTo(tripMap)
            .bindPopup('Tujuan perjalanan');

        // GARIS SIMULASI PERJALANAN
        const route = L.polyline(
            [
                driverPosition,
                pickupPosition,
                destinationPosition
            ],
            {
                color: '#164e3b',
                weight: 5,
                dashArray: '10, 8'
            }
        ).addTo(tripMap);

        tripMap.fitBounds(route.getBounds(), {
            padding: [60, 60]
        });

        setTimeout(function () {
            tripMap.invalidateSize();
        }, 300);

    }


    // ==============================
    // BATALKAN PERJALANAN
    // ==============================

    const cancelTrip = document.getElementById('cancelTrip');

    if (cancelTrip) {

        cancelTrip.addEventListener('click', function () {

            const confirmCancel = confirm(
                'Apakah kamu yakin ingin membatalkan pesanan?'
            );

            if (confirmCancel) {

                window.location.href =
                    'pesan_kendaraan.php';

            }

        });

    }

});
