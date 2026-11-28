<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| SIMULASI DATA PERJALANAN VOLTARA
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['perjalanan_voltara'])) {
    $_SESSION['perjalanan_voltara'] = [
        'status' => 'driver_arrived',
        'arrival_time' => time(),

        'driver' => 'Pak Hendra',
        'rating' => '4.9',
        'trip' => '1.240 trip sukses',
        'vehicle' => 'Toyota Innova Zenix EV Putih',
        'plate' => 'B 3552 EV',

        'pickup' => 'Kopi Kenangan Merr',
        'pickup_detail' => 'Depan Parkiran',

        'destination' => 'UPN Veteran Jawa Timur',
        'destination_detail' => 'Pintu Gerbang Utama Rungkut Madya, Surabaya',

        'passenger' => 'Dimas (1 Orang)',
        'vehicle_type' => 'VOLTARA CAR EV',

        'price' => 38000,
        'eta' => '58 mnt',
        'speed' => '52 km/h'
    ];
}

$trip = &$_SESSION['perjalanan_voltara'];

/*
|--------------------------------------------------------------------------
| AKSI PERJALANAN
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === 'boarded') {
        $trip['status'] = 'boarded';
    }

    if ($action === 'reset') {
        $trip['status'] = 'driver_arrived';
        $trip['arrival_time'] = time();
    }
}

/*
|--------------------------------------------------------------------------
| SETTING HALAMAN
|--------------------------------------------------------------------------
*/

$pageTitle  = 'VOLTARA - Perjalanan';
$pageCss    = 'perjalanan.css';
$pageJs     = 'penumpang/perjalanan.js';
$activePage = 'pesan';

$showHeader = true;
$showFooter = true;
$includeMap = true;

ob_start();
?>

<div class="trip-shell">

    <!-- =====================================================
         BAGIAN KIRI
    ====================================================== -->

    <section class="trip-left">

        <!-- CARD DRIVER DAN STATUS -->

        <div class="trip-card driver-card">

            <?php if ($trip['status'] === 'driver_arrived'): ?>

                <!-- DRIVER SUDAH SAMPAI -->

                <div class="arrival-banner">

                    <div class="arrival-heading">

                        <h2>♧ Pengemudi Sudah Sampai!</h2>

                        <span class="arrival-pill">
                            SIAP DIJEMPUT
                        </span>

                    </div>

                    <p>
                        Mohon segera temui driver di titik penjemputan
                        dalam kurun waktu 5 menit.
                    </p>

                    <div class="waiting-time-box">

                        <span class="waiting-label">
                            ◴ Waktu Tunggu Bebas Biaya:
                        </span>

                        <div class="countdown-wrapper">

                            <strong
                            id="countdown"
                            data-arrival-time="<?= (int)$trip['arrival_time'] ?>"
                        >
                            05:00
                        </strong>

                            <small>tersisa</small>

                        </div>

                    </div>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="action"
                            value="boarded"
                        >

                        <button
                            type="submit"
                            class="arrival-action"
                        >
                            Saya Menuju Lokasi
                        </button>

                    </form>

                </div>

            <?php else: ?>

                <!-- PENUMPANG SUDAH NAIK MOBIL -->

                <div class="boarded-banner">

                    <div class="boarded-heading">

                        <h2>♧ Status Naik Mobil</h2>

                        <span class="boarded-pill">
                            PERJALANAN AKTIF
                        </span>

                    </div>

                    <p>
                        Perjalanan Eco-Ride Anda sedang berlangsung.
                        Silakan nikmati perjalanan dengan nyaman.
                    </p>

                </div>

            <?php endif; ?>


            <!-- =================================================
                 PROFIL DRIVER
            ================================================== -->

            <div class="driver-profile">

                <div class="driver-photo">

                    <span>
                        <?= htmlspecialchars(substr($trip['driver'], 0, 1)) ?>
                    </span>

                </div>

                <div class="driver-profile-details">

                    <div class="driver-name-row">

                        <h3>
                            <?= htmlspecialchars($trip['driver']) ?>
                        </h3>

                        <span class="driver-badge">
                            Mitra Resmi EV
                        </span>

                    </div>

                    <p>
                        <?= htmlspecialchars($trip['trip']) ?>
                    </p>

                    <p>
                        <?= htmlspecialchars($trip['vehicle']) ?>
                    </p>

                </div>

                <div class="vehicle-plate">

                    <strong>
                        <?= htmlspecialchars($trip['plate']) ?>
                    </strong>

                    <small>VOLTARA</small>

                </div>

            </div>


            <!-- =================================================
                 KONTAK DRIVER
            ================================================== -->

            <div class="driver-contact-buttons">

                <a
                    href="https://wa.me/"
                    target="_blank"
                    class="contact-button"
                >
                    ▤ Hubungi WhatsApp
                </a>

                <a
                    href="tel:"
                    class="contact-button"
                >
                    ☎ Telepon Driver
                </a>

            </div>

        </div>


        <!-- =================================================
             DETAIL PERJALANAN
        ================================================== -->

        <div class="trip-card journey-card">

            <h2>Detail Perjalanan</h2>


            <!-- STATUS PERJALANAN -->

            <div class="journey-status">

                <span class="journey-status-icon">
                    ♧
                </span>

                <div class="journey-status-text">

                    <?php if ($trip['status'] === 'driver_arrived'): ?>

                        <strong>
                            Driver sampai di titik jemput
                        </strong>

                    <?php else: ?>

                        <strong>
                            Status Naik Mobil
                        </strong>

                    <?php endif; ?>

                    <small>
                        Perjalanan Eco-Ride Aktif
                    </small>

                </div>

                <?php if ($trip['status'] === 'boarded'): ?>

                    <div class="trip-statistics">

                        <div>

                            <strong>
                                <?= htmlspecialchars($trip['speed']) ?>
                            </strong>

                            <small>
                                Kecepatan Rerata
                            </small>

                        </div>

                        <div>

                            <strong>
                                <?= htmlspecialchars($trip['eta']) ?>
                            </strong>

                            <small>
                                Estimasi Sisa
                            </small>

                        </div>

                    </div>

                <?php endif; ?>

            </div>


            <!-- TITIK JEMPUT DAN TUJUAN -->

            <div class="route-details">

                <!-- TITIK JEMPUT -->

                <div class="route-item pickup-item">

                    <span class="route-icon pickup-icon">
                        ♧
                    </span>

                    <div>

                        <label>
                            TITIK JEMPUT
                        </label>

                        <strong>
                            <?= htmlspecialchars($trip['pickup']) ?>
                        </strong>

                        <small>
                            <?= htmlspecialchars($trip['pickup_detail']) ?>
                        </small>

                    </div>

                </div>


                <!-- TUJUAN AKHIR -->

                <div class="route-item destination-item">

                    <span class="route-icon destination-icon">
                        ⚑
                    </span>

                    <div>

                        <label>
                            TUJUAN AKHIR
                        </label>

                        <strong>
                            <?= htmlspecialchars($trip['destination']) ?>
                        </strong>

                        <small>
                            <?= htmlspecialchars($trip['destination_detail']) ?>
                        </small>

                    </div>

                </div>

            </div>


            <!-- PENUMPANG DAN ARMADA -->

            <div class="passenger-vehicle-grid">

                <div class="detail-box">

                    <span>♙</span>

                    <div>

                        <label>
                            PENUMPANG
                        </label>

                        <strong>
                            <?= htmlspecialchars($trip['passenger']) ?>
                        </strong>

                    </div>

                </div>

                <div class="detail-box">

                    <span>▣</span>

                    <div>

                        <label>
                            ARMADA
                        </label>

                        <strong>
                            <?= htmlspecialchars($trip['vehicle_type']) ?>
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             KESEPAKATAN TARIF
             MUNCUL SETELAH PENUMPANG NAIK
        ================================================== -->

        <?php if ($trip['status'] === 'boarded'): ?>

            <div class="trip-card fare-card">

                <div class="fare-heading">

                    <span>
                        Kesepakatan Tarif
                    </span>

                    <span class="locked-pill">
                        DEAL TERKUNCI
                    </span>

                    <small>
                        Saran: <del>Rp45.000</del>
                    </small>

                </div>

                <div class="fare-price-box">

                    <div>

                        <small>
                            Tawaran Disepakati:
                        </small>

                        <p>
                            Tanpa Komisi Tambahan
                        </p>

                    </div>

                    <strong>
                        Rp <?= number_format($trip['price'], 0, ',', '.') ?>
                    </strong>

                </div>

                <div class="cash-box">

                    <span>
                        ▣ Metode: Tunai ke Driver
                    </span>

                    <span class="cash-pill">
                        CASH ONLY
                    </span>

                </div>

                <div class="trip-action-buttons">

                    <button
                        type="button"
                        id="sosBtn"
                        class="sos-button"
                    >
                        ♧ Bantuan SOS
                    </button>

                    <button
                        type="button"
                        id="shareRouteBtn"
                        class="share-route-button"
                    >
                        ◉ Bagikan Rute
                    </button>

                </div>

            </div>

        <?php endif; ?>


        <!-- =================================================
             RIWAYAT PERGERAKAN
        ================================================== -->

        <div class="trip-history-card">

            <span class="history-icon">
                ▣
            </span>

            <div class="history-content">

                <strong>
                    Riwayat Pergerakan Driver
                </strong>

                <?php if ($trip['status'] === 'driver_arrived'): ?>

                    <p>
                        <?= htmlspecialchars($trip['driver']) ?>
                        telah tiba di titik jemput.
                    </p>

                <?php else: ?>

                    <p>
                        <?= htmlspecialchars($trip['driver']) ?>
                        sedang mengantarkan penumpang menuju tujuan.
                    </p>

                <?php endif; ?>

            </div>

            <span class="history-status">

                <?php if ($trip['status'] === 'driver_arrived'): ?>

                    ARRIVED

                <?php else: ?>

                    ON TRIP

                <?php endif; ?>

            </span>

        </div>


        <!-- =================================================
             RESET SIMULASI
        ================================================== -->

        <form method="POST" class="reset-trip-form">

            <input
                type="hidden"
                name="action"
                value="reset"
            >

            <button type="submit">
                Reset Simulasi Perjalanan
            </button>

        </form>

    </section>


    <!-- =====================================================
         BAGIAN KANAN: PETA
    ====================================================== -->

    <section class="trip-right">

        <div class="trip-map-card">

            <div class="trip-map-status">

                <span class="map-status-dot"></span>

                GPS Mobil Aktif: Alun-Alun Jombang

            </div>

            <div class="zero-emission">
                ⚡ ZERO EMISSION TRIP
            </div>

            <div id="map"></div>

        </div>


        <!-- INFORMASI KENDARAAN -->

        <div class="eco-information">

            <span class="eco-info-icon">
                ≋
            </span>

            <div>

                <strong>
                    AC Sejuk & Kabin Hening Tanpa Bising
                </strong>

                <p>
                    Innova Zenix EV beroperasi dengan baterai
                    terisi 92%. Perjalanan bersih & polusi
                    knalpot minimal.
                </p>

            </div>

        </div>

    </section>

</div>

<?php
$content = ob_get_clean();

require __DIR__ . '/../../layouts/main.php';
?>