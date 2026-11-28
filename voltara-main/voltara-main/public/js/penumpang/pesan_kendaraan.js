
document.addEventListener('DOMContentLoaded', function () {

    const pickup = document.getElementById('pickup');
    const destination = document.getElementById('destination');
    const locateBtn = document.getElementById('locateBtn');
    const swapBtn = document.getElementById('swapBtn');

    // =====================================
    // TUKAR LOKASI
    // =====================================

    if (swapBtn && pickup && destination) {

        swapBtn.addEventListener('click', function () {

            const temp = pickup.value;

            pickup.value = destination.value;
            destination.value = temp;

        });

    }


    // =====================================
    // GPS / LOKASI PENGGUNA
    // =====================================

    let map = null;

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

                    if (map) {
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


    // =====================================
    // PENAWARAN HARGA
    // =====================================

    const offerPrice = document.getElementById('offerPrice');
    const minusOffer = document.getElementById('minusOffer');
    const plusOffer = document.getElementById('plusOffer');
    const offerStatus = document.getElementById('offerStatus');
    const submitOffer = document.getElementById('submitOffer');
    const offerMessage = document.getElementById('offerMessage');

    if (
        offerPrice &&
        minusOffer &&
        plusOffer &&
        offerStatus
    ) {

        const MIN_PRICE = 35000;
        const STEP_PRICE = 5000;

        let currentPrice = 45000;

        function formatRupiah(price) {

            return 'Rp' + price.toLocaleString('id-ID');

        }

        function updateOffer() {

            offerPrice.textContent = formatRupiah(currentPrice);

            // Jika harga mencapai batas minimum
            if (currentPrice <= MIN_PRICE) {

                currentPrice = MIN_PRICE;

                offerPrice.textContent = formatRupiah(currentPrice);

                offerStatus.textContent = 'Tarif minimum tercapai';

                offerStatus.classList.add('minimum-reached');

                minusOffer.disabled = true;

            } else {

                offerStatus.textContent = 'Rekomendasi: Rp45.000';

                offerStatus.classList.remove('minimum-reached');

                minusOffer.disabled = false;

            }

        }

        // KURANGI HARGA
        minusOffer.addEventListener('click', function () {

            if (currentPrice > MIN_PRICE) {

                currentPrice -= STEP_PRICE;

                if (currentPrice < MIN_PRICE) {
                    currentPrice = MIN_PRICE;
                }

                updateOffer();

            }

        });


        // TAMBAH HARGA
        plusOffer.addEventListener('click', function () {

            currentPrice += STEP_PRICE;

            updateOffer();

        });


        // AJUKAN PENAWARAN (SIMULASI FRONT-END)
        if (submitOffer && offerMessage) {

            submitOffer.addEventListener('click', function () {

                offerMessage.textContent =
                    'Penawaran sebesar ' +
                    formatRupiah(currentPrice) +
                    ' berhasil disiapkan. ';

            });

        }

        // TAMPILKAN HARGA AWAL
        updateOffer();

    }


    // =====================================
    // PETA LEAFLET
    // =====================================

    if (typeof L !== 'undefined' && document.getElementById('map')) {

        map = L.map('map').setView(
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


        // DRIVER SIMULASI
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
        L.marker([-7.548, 112.235])

            .addTo(map)

            .bindPopup('Titik Jemput');


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


        // PERBAIKAN UKURAN PETA
        setTimeout(function () {

            map.invalidateSize();

        }, 300);

    }

});
