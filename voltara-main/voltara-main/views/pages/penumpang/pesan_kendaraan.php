
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle  = 'VOLTARA - Pesan Kendaraan';
$pageCss    = 'pesan_kendaraan.css';
$pageJs     = 'penumpang/pesan_kendaraan.js';
$activePage = 'pesan';

$showHeader = true;
$showFooter = true;
$includeMap = true;

$pickup = '';
$destination = '';
$message = '';
$showOffer = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup = trim($_POST['pickup'] ?? '');
    $destination = trim($_POST['destination'] ?? '');

    if ($pickup !== '' && $destination !== '') {
        $message = 'Lokasi berhasil dimasukkan.';
    } else {
        $message = 'Titik jemput dan tujuan wajib diisi.';
    }
}

ob_start();
?>

<div class="booking-shell">

    <!-- BAGIAN KIRI -->
    <section class="booking-left">

        <!-- FORM LOKASI -->
        <div class="booking-card main-form-card">

            <span class="section-label">
                TRANSAKSI ADIL & HIJAU
            </span>

            <div class="card-heading-row">
                <h1>Mau ke mana hari ini?</h1>
                <span class="car-icon">🚘</span>
            </div>

            <p class="intro">
                Tawar langsung harga terbaikmu ke mitra pengemudi.
                Nol emisi, 100% bayar tunai di tempat.
            </p>

            <form method="POST" class="location-form">

                <div class="route-line"></div>

                <!-- TITIK JEMPUT -->
                <div class="location-row pickup-row">

                    <span class="route-dot"></span>

                    <label for="pickup">TITIK JEMPUT</label>

                    <input
                        type="text"
                        id="pickup"
                        name="pickup"
                        value="<?= htmlspecialchars($pickup, ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="Lokasi Kamu"
                        autocomplete="off"
                        required
                    >

                    <button
                        type="button"
                        id="locateBtn"
                        class="locate-btn"
                        title="Gunakan lokasi"
                    >
                        ⌖
                    </button>

                </div>

                <!-- TUJUAN -->
                <div class="location-row destination-row">

                    <span class="route-flag">⚑</span>

                    <label for="destination">TUJUAN ANTAR</label>

                    <input
                        type="text"
                        id="destination"
                        name="destination"
                        value="<?= htmlspecialchars($destination, ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="Mau ke mana?"
                        autocomplete="off"
                        required
                    >

                    <button
                        type="button"
                        id="swapBtn"
                        class="swap-btn"
                        title="Tukar lokasi"
                    >
                        ↕
                    </button>

                </div>

                <button type="submit" class="search-btn">
                    Cari Pengemudi
                </button>

                <?php if ($message !== ''): ?>
                    <div class="form-message">
                        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>

            </form>

        </div>


        <!-- PILIHAN ARMADA -->
        <div class="booking-card vehicle-selection">

            <div class="selection-header">

                <span>PILIHAN ARMADA EV</span>

                <span class="green-pill">
                    100% BEBAS BISING
                </span>

            </div>

            <div class="vehicle-option">

                <img
                    src="../../../public/images/zenix.png"
                    alt="Toyota Innova Zenix"
                    class="vehicle-image"
                >

                <div class="vehicle-text">

                    <div class="vehicle-title">
                        <strong>VOLTARA CAR</strong>

                        <span class="premium">
                            PREMIUM
                        </span>
                    </div>

                    <small>Toyota Innova Zenix EV</small>

                    <span class="capacity">
                        Kapasitas 4–6 Org
                    </span>

                </div>

            </div>

        </div>


        <!-- KARTU PENAWARAN HARGA -->
        <div class="booking-card offer-card">

            <div class="offer-header">

                <h3>Tentukan Nominal Penawaranmu</h3>

                <span
                    class="recommendation"
                    id="offerStatus"
                >
                    Rekomendasi: Rp45.000
                </span>

            </div>

            <div class="offer-box">

                <button
                    type="button"
                    id="minusOffer"
                    class="price-adjust"
                    aria-label="Kurangi penawaran"
                >
                    −
                </button>

                <div class="price-display">

                    <label>NOMINAL TAWARAN ANDA</label>

                    <strong id="offerPrice">Rp45.000</strong>

                </div>

                <button
                    type="button"
                    id="plusOffer"
                    class="price-adjust"
                    aria-label="Tambah penawaran"
                >
                    +
                </button>

            </div>

            <button
                type="button"
                id="submitOffer"
                class="offer-submit"
            >
                CARI TAWARAN
            </button>

            <p class="offer-note" id="offerMessage">
                Silakan ajukan nominal penawaran kepada pengemudi.
            </p>

        </div>


        <!-- KARTU STATUS PENCARIAN -->
        <div
            class="booking-card waiting-card"
            id="waitingCard"
            hidden
        >

            <div class="waiting-header">

                <div class="waiting-title">

                    <span class="waiting-symbol">◎</span>

                    <strong id="waitingHeading">
                        Belum ada penawaran
                    </strong>

                </div>

                <span class="bidding-pill">
                    BIDDING AKTIF
                </span>

            </div>

            <!-- STATUS MENCARI -->
            <div
                class="driver-search-status"
                id="searchStatus"
            >

                <div class="search-icon-box">
                    <span class="search-icon">◎</span>
                </div>

                <div class="search-status-text">

                    <strong>Mencari Driver EV...</strong>

                    <div class="search-timer">

                        <span class="timer-dot"></span>

                        <span id="searchTimer">
                            Menghubungi armada terdekat (00:00)
                        </span>

                    </div>

                </div>

            </div>

            <!-- INFORMASI DRIVER YANG DIHUBUNGI -->
            <div
                class="driver-contact-info"
                id="driverContactInfo"
            >

                <div class="driver-avatar-group">

                    <span class="driver-avatar avatar-one">B</span>
                    <span class="driver-avatar avatar-two">D</span>
                    <span class="driver-avatar avatar-three">J</span>

                </div>

                <p>
                    Menghubungi
                    <strong>3 Driver EV</strong>
                    terdekat: Pak Budi, Mas Dimas, Pak Joko.
                </p>

            </div>

            <!-- ILUSTRASI PENCARIAN -->
            <div
                class="search-illustration"
                id="searchIllustration"
            >

                <div class="illustration-circle">

                    <span class="leaf leaf-left">✦</span>
                    <span class="leaf leaf-right">✦</span>

                    <div class="eco-face">

                        <span class="face-eye eye-left"></span>
                        <span class="face-eye eye-right"></span>

                        <span class="face-cheek cheek-left"></span>
                        <span class="face-cheek cheek-right"></span>

                        <span class="face-mouth"></span>

                    </div>

                    <div class="magnifier">

                        <div class="magnifier-lens"></div>
                        <span class="magnifier-handle"></span>

                    </div>

                </div>

                <p id="searchIllustrationText">
                    Lagi nyari Driver...
                </p>

            </div>


            <!-- DAFTAR PENAWARAN DRIVER -->
            <div
                id="driverOffers"
                class="driver-offers"
                hidden
            >

            </div>


            <!-- DRIVER TERPILIH -->
            <div
                id="selectedDriver"
                class="selected-driver-box"
                hidden
            >

            </div>


            <!-- PEMBAYARAN -->
            <div class="payment-info">

                <span class="payment-icon">▣</span>

                <div>

                    <strong>Metode Pembayaran: TUNAI (CASH)</strong>

                    <p>
                        Bayar langsung ke mitra driver setelah sampai.
                        Tanpa saldo dompet digital dan tanpa potongan
                        tak transparan.
                    </p>

                </div>

            </div>


            <!-- KONFIRMASI -->
            <button
                type="button"
                class="confirm-booking"
                id="confirmBooking"
                hidden
            >
                ✓ Konfirmasi & Tunggu Driver Menuju Lokasi
            </button>


            <!-- BATALKAN -->
            <button
                type="button"
                class="cancel-booking"
                id="cancelBooking"
            >
                ✕ Batalkan Pesanan
            </button>

            <p class="cancel-note">
                Driver terdekat biasanya menerima dalam waktu 1–2 menit.
            </p>

        </div>

    </section>


    <!-- BAGIAN KANAN -->
    <section class="booking-right">

        <!-- PETA -->
        <div class="map-card">

            <div class="map-status">

                <span class="status-dot"></span>

                <strong>3 Driver VOLTARA CAR Aktif</strong>

                <span>• Radius 1.5 km dekat Alun-Alun</span>

            </div>

            <div id="map"></div>

        </div>


        <!-- INFORMASI -->
        <div class="info-cards">

            <div class="info-card">

                <span class="info-icon shield">♧</span>

                <div>

                    <strong>Perlindungan Perjalanan Hijau</strong>

                    <p>
                        Asuransi perjalanan otomatis aktif
                        tanpa biaya tambahan.
                    </p>

                </div>

            </div>

            <div class="info-card">

                <span class="info-icon deal">↙</span>

                <div>

                    <strong>Harga Deal & Tanpa Sengketa</strong>

                    <p>
                        Driver menyetujui tawaranmu sebelum
                        berangkat ke titik jemput.
                    </p>

                </div>

            </div>

        </div>

    </section>

</div>

<?php
$content = ob_get_clean();

require __DIR__ . '/../../layouts/main.php';
?>