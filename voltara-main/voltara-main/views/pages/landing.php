<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proses logout
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();

    header('Location: /voltara-app/views/pages/landing.php');
    exit;
}

$pageTitle  = "VOLTARA - Perjalanan Ramah Lingkungan";
$pageCss    = "landing.css";
$activePage = "beranda";

$isPublicPage = true;

$showHeader = true;
$showFooter = true;

$steps = [
    [
        "number" => "01",
        "label" => "TAHAP 01 · Lokasi Titik",
        "title" => "Tentukan Tujuan",
        "description" => "Masukkan titik jemput dan tujuanmu secara akurat di peta digital cerdas tanpa batasan rute.",
        "icon" => "⌖",
        "tag" => "Pinpoint Lokasi Presisi"
    ],
    [
        "number" => "02",
        "label" => "TAHAP 02 · Input Tarif",
        "title" => "Ajukan Tarif",
        "description" => "Ketik nominal tawaran yang pas dengan anggaranmu sendiri. Bebas dari lonjakan otomatis algoritma dinamis.",
        "icon" => "☷",
        "tag" => "Fleksibel Tanpa Algoritma"
    ],
    [
        "number" => "03",
        "label" => "TAHAP 03 · Respon Driver",
        "title" => "Negosiasi Driver",
        "description" => "Driver dapat langsung menyetujui atau mengajukan harga tandingan. Kamu leluasa memilih driver terbaik.",
        "icon" => "▤",
        "tag" => "Deal Transparan Dua Arah"
    ],
    [
        "number" => "04",
        "label" => "TAHAP 04 · Perjalanan & Bayar",
        "title" => "Jalan & Bayar Tunai",
        "description" => "Nikmati kabin senyap kendaraan listrik, lalu selesaikan pembayaran tunai ke mitra tanpa potongan saldo tersembunyi.",
        "icon" => "▣",
        "tag" => "Tunai di Akhir Trip"
    ]
];

$benefits = [
    [
        "icon" => "◈",
        "title" => "Kabin Senyap & Sejuk",
        "description" => "AC otomatis efisien dengan kenyamanan motor listrik murni."
    ],
    [
        "icon" => "♧",
        "title" => "Zero Tailpipe Emissions",
        "description" => "Turut menurunkan polusi udara di setiap kilometer perjalanan."
    ],
    [
        "icon" => "▣",
        "title" => "Driver Profesional",
        "description" => "Mitra terlatih dalam keselamatan berkendara dan lingkungan."
    ],
    [
        "icon" => "◎",
        "title" => "Keamanan Terstandar",
        "description" => "Fitur keselamatan aktif, sabuk pengaman menyeluruh, dan monitoring rute."
    ]
];

ob_start();
?>

<!-- ================= HERO SECTION ================= -->

<section class="hero" id="beranda">

    <div class="hero-overlay"></div>

    <div class="floating-leaf leaf-one">◆</div>
    <div class="floating-leaf leaf-two">◆</div>
    <div class="floating-leaf leaf-three">◆</div>

    <div class="hero-content">

        <div class="hero-badge">
            DEAL HARGANYA, CLEAN JALANNYA
        </div>

        <h1>
            Nikmati Perjalanan Ramah Lingkungan
            Bersama <span>VOLTARA</span>
        </h1>

        <p>
            Nikmati perjalanan dengan armada mobil listrik resmi VOLTARA.
            Tentukan tarif sendiri, negosiasi langsung dengan driver tanpa
            lonjakan biaya, bayar tunai setelah sampai.
        </p>

        <a href="/voltara-app/views/pages/login.php" class="hero-button">
            Masuk untuk Pesan
        </a>

        <div class="hero-stats">

            <div>
                <strong>100%</strong>
                <span>Armada EV Murni</span>
            </div>

            <div>
                <strong>Rp0</strong>
                <span>Biaya Tambahan</span>
            </div>

            <div>
                <strong>Tunai</strong>
                <span>Bayar di Tempat</span>
            </div>

        </div>

    </div>

</section>


<!-- ================= RUNNING INFORMATION ================= -->

<div class="ticker">

    <div class="ticker-content">
        <span>⚡ DEAL HARGANYA, CLEAN JALANNYA.</span>
        <span>◆</span>
        <span>◉ 100% MOBIL LISTRIK MURNI</span>
        <span>◆</span>
        <span>♧ NEGO TARIF LANGSUNG DRIVER</span>
        <span>◆</span>
        <span>▣ BAYAR TUNAI TANPA POTONGAN</span>
        <span>◆</span>
        <span>◎ TANPA ALGORITMA TARIF DINAMIS</span>
    </div>

</div>


<!-- ================= HOW IT WORKS ================= -->

<section class="how-section" id="cara-kerja">

    <div class="section-heading">

        <span class="section-badge">⚡ ALUR PERJALANAN INTUITIF</span>

        <h2>Sesimpel Itu Cara Kerjanya.</h2>

        <p>
            Empat langkah mudah dijemput hingga sampai tujuan dengan armada
            mobil listrik resmi dan transparansi tarif tanpa kejutan.
        </p>

    </div>


    <div class="steps-grid">

        <?php foreach ($steps as $index => $step): ?>

            <article class="step-card <?= $index === 3 ? 'highlight' : '' ?>">

                <div class="step-top">

                    <span class="step-number">
                        <?= htmlspecialchars($step['number']) ?>
                    </span>

                    <span class="step-icon">
                        <?= htmlspecialchars($step['icon']) ?>
                    </span>

                </div>

                <small><?= htmlspecialchars($step['label']) ?></small>

                <h3><?= htmlspecialchars($step['title']) ?></h3>

                <p><?= htmlspecialchars($step['description']) ?></p>

                <span class="step-tag">
                    ✓ <?= htmlspecialchars($step['tag']) ?>
                </span>

            </article>

        <?php endforeach; ?>

    </div>

</section>


<!-- ================= PRICE NEGOTIATION ================= -->

<section class="pricing-section" id="pricing">
    
    <div class="pricing-container">

        <div class="pricing-content">

            <span class="dark-badge">
                TRANSPARANSI KESEPAKATAN
            </span>

            <h2>
                Your Price. Your Choice.
            </h2>

            <p>
                Bukan sekadar mengikuti tarif. Kamu punya kesempatan
                untuk mengajukan harga dan mencapai kesepakatan
                langsung dengan driver.
            </p>

            <div class="pricing-stats">

                <div class="pricing-stat">
                    <strong>~15 Detik</strong>
                    <span>Rata-rata waktu kesepakatan</span>
                </div>

                <div class="pricing-stat">
                    <strong>100%</strong>
                    <span>Bebas lonjakan tersembunyi</span>
                </div>

            </div>

            <div class="pricing-note">
                ♙ Metode pembayaran tunai murni tanpa sistem koin aplikasi.
            </div>

        </div>


        <!-- SIMULATION CARD -->

        <div class="bidding-card">

            <div class="bidding-header">

                <div>
                    <span class="live-dot"></span>
                    <strong>LIVE DRIVER BIDDING</strong>
                </div>

                <span class="offer-count">3 Penawaran Masuk</span>

            </div>

            <div class="route-info">
                <strong>⌖ SBCD - Pondok Indah</strong>
                <small>Tawaran Awal: <b>Rp25.000</b></small>
            </div>


            <!-- DRIVER 1 -->

            <div class="driver-offer active-offer">

                <div class="driver-avatar">PH</div>

                <div class="driver-details">
                    <strong>Pak Hendra <small>★ 4.9 (1.2k)</small></strong>
                    <span>VOLTARA EV · 3 mnt (450m)</span>
                    <button class="accept-button">✓ Disepakati</button>
                </div>

                <div class="driver-price">
                    <strong>Rp28.000</strong>
                    <span>DEAL</span>
                </div>

            </div>


            <!-- DRIVER 2 -->

            <div class="driver-offer">

                <div class="driver-avatar gray">PB</div>

                <div class="driver-details">
                    <strong>Pak Bayu <small>★ 4.8</small></strong>
                    <span>VOLTARA EV · 6 mnt</span>
                    <button class="offer-button">Terima</button>
                </div>

                <div class="driver-price">
                    <strong>Rp30.000</strong>
                </div>

            </div>


            <!-- DRIVER 3 -->

            <div class="driver-offer">

                <div class="driver-avatar gray">IR</div>

                <div class="driver-details">
                    <strong>Ibu Rina <small>★ 5.0</small></strong>
                    <span>VOLTARA EV · 8 mnt</span>
                    <button class="offer-button">Terima</button>
                </div>

                <div class="driver-price">
                    <strong>Rp26.000</strong>
                </div>

            </div>

            <div class="final-price">
                ✓ Tarif disepakati langsung: Rp28.000 (Bayar Tunai saat sampai)
            </div>

        </div>

    </div>

</section>


<!-- ================= VEHICLE SECTION ================= -->

<section class="vehicle-section" id="keunggulan">

    <div class="vehicle-heading">

        <div>
            <span class="section-badge">KABIN MODERN & BERSIH</span>

            <h2>
                More Than a Ride. A Cleaner Way
                <br>
                to Move.
            </h2>
        </div>

        <p>
            Rasakan pengalaman perjalanan dengan mobil listrik
            yang nyaman, modern, dan lebih ramah lingkungan.
        </p>

    </div>


    <div class="vehicle-card">

        <div class="vehicle-image">

            <img
    src="/voltara-app/public/img/voltara-car.jpg"
    alt="Armada mobil listrik VOLTARA"
>

            <div class="vehicle-overlay">

                <span class="vehicle-badge">
                    UNIT ARMADA RESMI VOLTARA
                </span>

                <h2>
                    Kabin Luas, Senyap, dan Berenergi Bersih
                </h2>

            </div>

            <div class="emission-badge">
                <strong>◉ 0 g/km CO₂</strong>
                <small>Emisi Langsung di Rute Perkotaan</small>
            </div>

        </div>


        <div class="benefits-grid">

            <?php foreach ($benefits as $benefit): ?>

                <div class="benefit-item">

                    <div class="benefit-icon">
                        <?= htmlspecialchars($benefit['icon']) ?>
                    </div>

                    <div>
                        <h4><?= htmlspecialchars($benefit['title']) ?></h4>
                        <p><?= htmlspecialchars($benefit['description']) ?></p>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<!-- ================= CALL TO ACTION ================= -->

<section class="cta-section">

    <div class="cta-content">

        <span class="cta-badge">SIAP MENGASPAL BERSIH?</span>

        <h2>
            Deal Harganya, Clean Jalannya
            <br>
            Sekarang Juga!
        </h2>

        <p>
            Gunakan platform VOLTARA tanpa ribet untuk berangkat.
            Cukup masukkan tujuan dan tentukan harga pertama kamu!
        </p>

    </div>

    <div class="cta-buttons">

        <a href="/voltara-app/views/pages/login.php" class="cta-primary">
            Pesan Perjalanan
        </a>

<a href="/voltara-app/views/pages/driver.php" class="cta-secondary">
            Daftar Mitra Driver
        </a>

    </div>

</section>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
