
document.addEventListener('DOMContentLoaded', function () {

    const pickup = document.getElementById('pickup');
    const destination = document.getElementById('destination');
    const locateBtn = document.getElementById('locateBtn');
    const swapBtn = document.getElementById('swapBtn');

    const offerPrice = document.getElementById('offerPrice');
    const minusOffer = document.getElementById('minusOffer');
    const plusOffer = document.getElementById('plusOffer');
    const offerStatus = document.getElementById('offerStatus');
    const submitOffer = document.getElementById('submitOffer');
    const offerMessage = document.getElementById('offerMessage');

    const waitingCard = document.getElementById('waitingCard');
    const waitingHeading = document.getElementById('waitingHeading');
    const searchStatus = document.getElementById('searchStatus');
    const driverContactInfo = document.getElementById('driverContactInfo');
    const searchIllustration = document.getElementById('searchIllustration');
    const searchIllustrationText = document.getElementById('searchIllustrationText');
    const searchTimer = document.getElementById('searchTimer');

    const driverOffers = document.getElementById('driverOffers');
    const selectedDriver = document.getElementById('selectedDriver');
    const confirmBooking = document.getElementById('confirmBooking');
    const cancelBooking = document.getElementById('cancelBooking');

    let map = null;
    let currentPrice = 45000;
    const MIN_PRICE = 35000;
    const STEP_PRICE = 5000;

    let searchInterval = null;
    let searchTimeout = null;
    let elapsedSeconds = 0;
    let selectedDriverData = null;
    let searchActive = false;

    // =====================================
    // FORMAT RUPIAH
    // =====================================

    function formatRupiah(price) {
        return 'Rp' + price.toLocaleString('id-ID');
    }


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

    function updateOffer() {

        offerPrice.textContent = formatRupiah(currentPrice);

        if (currentPrice <= MIN_PRICE) {

            currentPrice = MIN_PRICE;
            offerPrice.textContent = formatRupiah(currentPrice);

            offerStatus.textContent = 'Tarif minimum tercapai';
            offerStatus.classList.add('minimum-reached');

            minusOffer.disabled = true;

            offerMessage.textContent =
                'Tawaran Anda ' + formatRupiah(currentPrice) +
                ' (Harga minimum sistem).';

        } else {

            offerStatus.textContent = 'Rekomendasi: Rp45.000';
            offerStatus.classList.remove('minimum-reached');

            minusOffer.disabled = false;

            offerMessage.textContent =
                'Silahkan ajukan nominal penawaran kepada pengemudi.';

        }

    }


    if (offerPrice && minusOffer && plusOffer && offerStatus) {

        minusOffer.addEventListener('click', function () {

            if (currentPrice > MIN_PRICE) {

                currentPrice -= STEP_PRICE;

                if (currentPrice < MIN_PRICE) {
                    currentPrice = MIN_PRICE;
                }

                updateOffer();

            }

        });


        plusOffer.addEventListener('click', function () {

            currentPrice += STEP_PRICE;

            updateOffer();

        });

        updateOffer();

    }


    // =====================================
    // DATA DRIVER SIMULASI
    // =====================================

    const drivers = [

        {
            name: 'Pak Hendra',
            rating: '4.9 ★',
            reviews: '1.2k',
            vehicle: 'Innova Zenix EV',
            plate: 'B 3552 EV',
            distance: '450 m',
            eta: '3 mnt',
            price: 38000,
            initial: 'H'
        },

        {
            name: 'Pak Joko',
            rating: '4.8 ★',
            reviews: '',
            vehicle: 'Innova Zenix EV',
            plate: 'B 1908 EV',
            distance: '1.1 km',
            eta: '6 mnt',
            price: 40000,
            initial: 'J'
        },

        {
            name: 'Ibu Rina',
            rating: '5.0 ★',
            reviews: '',
            vehicle: 'Innova Zenix EV',
            plate: 'B 2741 EV',
            distance: '1.4 km',
            eta: '8 mnt',
            price: 37000,
            initial: 'R'
        }

    ];


    // =====================================
    // TIMER PENCARIAN
    // =====================================

    function startTimer() {

        elapsedSeconds = 0;

        searchTimer.textContent =
            'Menghubungi armada terdekat (00:00)';

        searchInterval = setInterval(function () {

            elapsedSeconds++;

            const minutes = String(
                Math.floor(elapsedSeconds / 60)
            ).padStart(2, '0');

            const seconds = String(
                elapsedSeconds % 60
            ).padStart(2, '0');

            searchTimer.textContent =
                'Menghubungi armada terdekat (' +
                minutes + ':' + seconds + ')';

        }, 1000);

    }


    function stopTimer() {

        if (searchInterval) {

            clearInterval(searchInterval);
            searchInterval = null;

        }

    }


    // =====================================
    // MEMBUAT KARTU DRIVER
    // =====================================

    function renderDrivers() {

        driverOffers.innerHTML = '';

        drivers.forEach(function (driver, index) {

            const card = document.createElement('div');

            card.className = 'driver-offer-item';

            card.innerHTML = `
                <div class="driver-offer-top">

                    <div class="driver-profile">

                        <div class="driver-photo-placeholder">
                            ${driver.initial}
                        </div>

                        <div class="driver-profile-info">

                            <strong>${driver.name}</strong>

                            <span class="driver-rating">
                                ${driver.rating}
                                ${driver.reviews}
                            </span>

                            <div class="driver-details">
                                ▧ ${driver.vehicle} • ${driver.plate}
                                <br>
                                ★ ${driver.eta} (${driver.distance})
                            </div>

                        </div>

                    </div>

                    <div class="driver-price-area">

                        <small>TAWARAN DRIVER</small>

                        <strong>${formatRupiah(driver.price)}</strong>

                    </div>

                </div>

                <button
                    type="button"
                    class="choose-driver-btn"
                    data-index="${index}"
                >
                    Pilih Penawaran
                </button>
            `;

            driverOffers.appendChild(card);

        });


        // EVENT PILIH DRIVER

        const chooseButtons = driverOffers.querySelectorAll(
            '.choose-driver-btn'
        );

        chooseButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                const index = Number(button.dataset.index);

                chooseDriver(index);

            });

        });

    }


    // =====================================
    // PILIH DRIVER
    // =====================================

    
function chooseDriver(index) {

    const driver = drivers[index];

    // Ambil lokasi dari input halaman pencarian
    const pickupValue = pickup.value.trim();
    const destinationValue = destination.value.trim();

    // Siapkan data driver dan perjalanan
    const params = new URLSearchParams();

    params.set('driver', driver.name);
    params.set('vehicle', driver.vehicle);
    params.set('plate', driver.plate);
    params.set('pickup', pickupValue);
    params.set('destination', destinationValue);
    params.set('price', driver.price);
    params.set('eta', '58');
    params.set('distance', '52');

    // Pindah ke halaman driver menuju lokasi penumpang
    window.location.href =
        'otw.php?' + params.toString();

}


    // =====================================
    // MULAI PENCARIAN
    // =====================================

    if (submitOffer) {

        submitOffer.addEventListener('click', function () {

            if (searchActive) {
                return;
            }

            if (
                !pickup.value.trim() ||
                !destination.value.trim()
            ) {

                alert('Titik jemput dan tujuan wajib diisi.');

                return;

            }


            searchActive = true;

            waitingCard.hidden = false;

            waitingHeading.textContent =
                'Belum ada penawaran';

            searchStatus.hidden = false;
            driverContactInfo.hidden = false;
            searchIllustration.hidden = false;

            searchIllustrationText.textContent =
                'Lagi nyari Driver...';

            driverOffers.hidden = true;
            selectedDriver.hidden = true;
            confirmBooking.hidden = true;

            submitOffer.disabled = true;

            offerMessage.textContent =
                'Penawaran ' + formatRupiah(currentPrice) +
                ' sedang dikirim ke driver terdekat.';

            startTimer();


            // SIMULASI DRIVER MEMBALAS SETELAH 3 DETIK

            searchTimeout = setTimeout(function () {

                stopTimer();

                waitingHeading.textContent =
                    '3 Penawaran Driver Masuk';

                searchStatus.hidden = true;
                driverContactInfo.hidden = true;
                searchIllustration.hidden = true;

                driverOffers.hidden = false;

                renderDrivers();

            }, 3000);

        });

    }


    // =====================================
    // KONFIRMASI PESANAN
    // =====================================

    if (confirmBooking) {

        confirmBooking.addEventListener('click', function () {

            if (!selectedDriverData) {
                alert('Silahkan pilih driver terlebih dahulu.');
                return;
            }

            alert(
                'Pesanan berhasil dikonfirmasi!\n\n' +
                'Driver: ' + selectedDriverData.name + '\n' +
                'Kendaraan: ' + selectedDriverData.vehicle + '\n' +
                'Nominal: ' + formatRupiah(selectedDriverData.price) +
                '\n\nSimulasi: driver sedang menuju lokasi.'
            );

            confirmBooking.textContent =
                '✓ Pesanan Telah Dikonfirmasi';

            confirmBooking.disabled = true;

        });

    }


    // =====================================
    // BATALKAN PESANAN
    // =====================================

    if (cancelBooking) {

        cancelBooking.addEventListener('click', function () {

            const confirmCancel = confirm(
                'Apakah kamu yakin ingin membatalkan pencarian driver?'
            );

            if (!confirmCancel) {
                return;
            }

            stopTimer();

            if (searchTimeout) {

                clearTimeout(searchTimeout);
                searchTimeout = null;

            }

            searchActive = false;
            selectedDriverData = null;

            waitingCard.hidden = true;

            driverOffers.innerHTML = '';
            driverOffers.hidden = true;

            selectedDriver.hidden = true;
            confirmBooking.hidden = true;

            confirmBooking.disabled = false;

            confirmBooking.textContent =
                '✓ Konfirmasi & Tunggu Driver Menuju Lokasi';

            submitOffer.disabled = false;

            offerMessage.textContent =
                'Pencarian driver berhasil dibatalkan.';

        });

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

        const mapDrivers = [

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


        mapDrivers.forEach(function (driver) {

            L.marker([driver.lat, driver.lng])

                .addTo(map)

                .bindPopup(driver.name);

        });


        L.marker([-7.548, 112.235])

            .addTo(map)

            .bindPopup('Titik Jemput Simulasi');


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


        setTimeout(function () {

            map.invalidateSize();

        }, 300);

    }

});
