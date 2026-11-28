
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle  = 'VOLTARA - Driver Menuju Lokasi';
$pageCss    = 'otw.css';
$pageJs     = 'penumpang/otw.js';
$activePage = 'pesan';

$showHeader = true;
$showFooter = true;
$includeMap = true;

// Data dari halaman pencarian driver
$driverName = htmlspecialchars($_GET['driver'] ?? 'Pak Hendra', ENT_QUOTES, 'UTF-8');
$vehicle    = htmlspecialchars($_GET['vehicle'] ?? 'Toyota Innova Zenix EV Putih', ENT_QUOTES, 'UTF-8');
$plate      = htmlspecialchars($_GET['plate'] ?? 'B 3552 EV', ENT_QUOTES, 'UTF-8');
$pickup     = htmlspecialchars($_GET['pickup'] ?? 'Kopi Kenangan Merr', ENT_QUOTES, 'UTF-8');
$destination = htmlspecialchars($_GET['destination'] ?? 'UPN Veteran Jawa Timur', ENT_QUOTES, 'UTF-8');
$price      = htmlspecialchars($_GET['price'] ?? '38000', ENT_QUOTES, 'UTF-8');
$eta        = htmlspecialchars($_GET['eta'] ?? '58', ENT_QUOTES, 'UTF-8');
$distance   = htmlspecialchars($_GET['distance'] ?? '52', ENT_QUOTES, 'UTF-8');

ob_start();
?>

<div class="trip-page">

    <!-- KARTU PERJALANAN -->
    <section class="trip-left">

        <!-- PROFIL DRIVER -->
        <div class="trip-card">

            <div class="driver-profile">

                <div class="driver-photo">
                    <?= strtoupper(substr($driverName, 0, 1)) ?>
                </div>

                <div class="driver-information">

                    <div class="driver-name-row">
                        <strong><?= $driverName ?></strong>

                        <span class="verified-driver">
                            Mitra Resmi EV
                        </span>
                    </div>

                    <small>1.240 trip sukses</small>

                    <small><?= $vehicle ?></small>

                </div>

                <div class="vehicle-plate">

                    <strong><?= $plate ?></strong>

                    <small>VOLTARA</small>

                </div>

            </div>

            <!-- KONTAK DRIVER -->
            <div class="driver-buttons">

                <a href="#" class="driver-contact whatsapp">
                    ▣ Hubungi WhatsApp
                </a>

                <a href="#" class="driver-contact telephone">
                    ☎ Telepon Driver
                </a>

            </div>

            <!-- DETAIL PERJALANAN -->
            <div class="trip-detail">

                <h2>Detail Perjalanan</h2>

                <!-- INFO KECEPATAN DAN ESTIMASI -->
                <div class="trip-summary">

                    <div class="summary-icon">♧</div>

                    <div class="summary-description">
                        <strong>Driver menuju lokasi kamu</strong>
                        <small>Perjalanan Eco-Ride Aktif</small>
                    </div>

                    <div class="summary-data">
                        <strong><?= $distance ?> km/h</strong>
                        <small>Kecepatan Rerata</small>
                    </div>

                    <div class="summary-data">
                        <strong><?= $eta ?> mnt</strong>
                        <small>Estimasi Sisa</small>
                    </div>

                </div>

                <!-- TITIK JEMPUT -->
                <div class="trip-location pickup-location">

                    <div class="location-symbol pickup-symbol">
                        ●
                    </div>

                    <div class="location-information">

                        <small>TITIK JEMPUT</small>

                        <strong><?= $pickup ?></strong>

                        <span>Lokasi penjemputan penumpang</span>

                    </div>

                </div>

                <!-- TUJUAN -->
                <div class="trip-location destination-location">

                    <div class="location-symbol destination-symbol">
                        ◈
                    </div>

                    <div class="location-information">

                        <small>TUJUAN AKHIR</small>

                        <strong><?= $destination ?></strong>

                        <span>Lokasi tujuan perjalanan</span>

                    </div>

                </div>

                <!-- INFORMASI PENUMPANG DAN ARMADA -->
                <div class="trip-extra">

                    <div class="extra-information">

                        <small>♙ PENUMPANG</small>

                        <strong>Dimas (1 Orang)</strong>

                    </div>

                    <div class="extra-information">

                        <small>▣ ARMADA</small>

                        <strong>VOLTARA CAR EV</strong>

                    </div>

                </div>

            </div>

        </div>

        <!-- BATALKAN PESANAN -->
        <div class="cancel-trip-card">

            <button
                type="button"
                id="cancelTrip"
                class="cancel-trip-button"
            >
                ⊗ Batalkan Pesanan
            </button>

            <p>
                Driver terdekat biasanya menerima dalam waktu 1–2 menit.
            </p>

        </div>

    </section>


    <!-- BAGIAN PETA -->
    <section class="trip-right">

        <div class="trip-map-card">

            <!-- STATUS GPS -->
            <div class="map-gps-status">

                <span class="gps-dot"></span>

                GPS Mobil Aktif: Alun-Alun Jombang

            </div>

            <!-- BADGE ZERO EMISSION -->
            <div class="zero-emission">

                ⚡ ZERO EMISSION TRIP

            </div>

            <!-- MAP -->
            <div id="tripMap"></div>

            <!-- INFO KENDARAAN -->
            <div class="eco-information">

                <div class="eco-information-icon">
                    ≋
                </div>

                <div>

                    <strong>AC Sejuk & Kabin Hening Tanpa Bising</strong>

                    <p>
                        Innova Zenix EV beroperasi hening dengan
                        baterai terisi 92%. Perjalanan bersih
                        & polusi knalpot.
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
