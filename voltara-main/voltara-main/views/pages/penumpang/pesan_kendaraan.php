
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle  = 'VOLTARA - Pesan Kendaraan';
$pageCss    = 'pesan_kendaraan.css';
$pageJs     = 'penumpang/pesan_kendaraan.js';
$activePage = 'pesan_kendaraan';

$showHeader = true;
$showFooter = true;
$includeMap = true;

$pickup = '';
$destination = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickup = trim($_POST['pickup'] ?? '');
    $destination = trim($_POST['destination'] ?? '');

    if ($pickup !== '' && $destination !== '') {
        $message = 'Lokasi jemput dan tujuan berhasil diisi.';
    } else {
        $message = 'Titik jemput dan tujuan wajib diisi.';
    }
}

ob_start();
?>

<div class="booking-shell">

    <!-- BAGIAN KIRI -->
    <section class="booking-left">

        <!-- FORM PEMESANAN -->
        <div class="booking-card main-form-card">

            <span class="section-label">
                TRANSAKSI ADIL & HIJAU
            </span>

            <div class="card-heading-row">
                <h1>Mau ke mana hari ini?</h1>

                <span class="car-icon">
                    🚘
                </span>
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

                    <label for="pickup">
                        TITIK JEMPUT
                    </label>

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

                    <span class="route-flag">
                        ⚑
                    </span>

                    <label for="destination">
                        TUJUAN ANTAR
                    </label>

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
                    src="/voltara-app/public/img/voltara-car.svg"
                    alt="VOLTARA CAR"
                >

                <div class="vehicle-text">

                    <div class="vehicle-title">

                        <strong>VOLTARA CAR</strong>

                        <span class="premium">
                            PREMIUM
                        </span>

                    </div>

                    <small>
                        Toyota Innova Zenix EV
                    </small>

                    <span class="capacity">
                        Kapasitas 4–6 Org
                    </span>

                </div>

            </div>

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

                <span class="info-icon shield">
                    ♧
                </span>

                <div>

                    <strong>
                        Perlindungan Perjalanan Hijau
                    </strong>

                    <p>
                        Asuransi perjalanan otomatis aktif
                        tanpa biaya tambahan.
                    </p>

                </div>

            </div>


            <div class="info-card">

                <span class="info-icon deal">
                    ↙
                </span>

                <div>

                    <strong>
                        Harga Deal & Tanpa Sengketa
                    </strong>

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
