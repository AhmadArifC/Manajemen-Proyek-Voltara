
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/voltara-app';

$pageTitle = 'VOLTARA - Mode Pengemudi';
$pageCss = 'driver.css';
$activePage = 'beranda';

$isPublicPage = true;
$isLoginPage = false;
$isDriverPage = true;

$showHeader = true;
$showFooter = true;

$error = $_SESSION['driver_error'] ?? '';
unset($_SESSION['driver_error']);

$phone = $_SESSION['driver_phone'] ?? '';

ob_start();
?>

<div class="driver-page">

    <!-- HERO -->
    <section class="driver-hero">

        <div class="driver-left">

            <span class="driver-main-badge">
                ◉ MITRA PENGEMUDI RESMI · 100% MOBIL LISTRIK (RODA 4)
            </span>

            <h1>
                Nyetir Tenang, Rezeki
                Utuh Tanpa Potongan
                Komisi.
            </h1>

            <p class="driver-description">
                Gabung bersama ribuan pengemudi mobil listrik
                <strong>VOLTARA CAR.</strong>
                Deal langsung dengan penumpang, uang tunai dan QRIS
                100% masuk ke dompet Anda tanpa potongan aplikasi
                sepersepuluh pun.
            </p>

            <!-- KEUNGGULAN -->
            <div class="driver-benefits">

                <article class="driver-benefit">
                    <span class="benefit-symbol lime">♧</span>
                    <h3>0% Komisi Tetap</h3>
                    <p>
                        Semua hasil kesepakatan ongkos diterima utuh,
                        tanpa potongan admin per trip.
                    </p>
                </article>

                <article class="driver-benefit">
                    <span class="benefit-symbol green">↕</span>
                    <h3>Fleksibilitas Nego</h3>
                    <p>
                        Berhak tawar balik tawaran penumpang sesuai
                        rute dan kondisi kapasitas baterai Anda.
                    </p>
                </article>

                <article class="driver-benefit">
                    <span class="benefit-symbol blue">▣</span>
                    <h3>SPKLU Prioritas</h3>
                    <p>
                        Akses fast-charging rekanan resmi dengan
                        jalur reservasi tanpa antre dan diskon tarif.
                    </p>
                </article>

            </div>

            <!-- SIMULASI PENDAPATAN -->
            <section class="income-card">

                <div class="income-heading">
                    <strong>▣ SIMULASI ESTIMASI PENDAPATAN BERSIH</strong>
                    <span>Kalkulator Real-time</span>
                </div>

                <div class="income-content">

                    <div class="trip-target">
                        <span>Target Perjalanan Harian:</span>
                        <strong>8 Trip / Hari</strong>

                        <div class="trip-progress">
                            <span></span>
                        </div>

                        <div class="trip-labels">
                            <small>Santai (4 trip)</small>
                            <small>Produktif (8 trip)</small>
                            <small>Maksimal (16 trip)</small>
                        </div>
                    </div>

                    <div class="income-result">

                        <div class="income-row">
                            <span>Pendapatan Kotor:</span>
                            <strong>Rp336.000<small>/hari</small></strong>
                        </div>

                        <div class="income-row deduction">
                            <span>Potongan Komisi VOLTARA:</span>
                            <strong>Rp0</strong>
                        </div>

                        <div class="monthly-income">
                            <span>Estimasi Bulanan Bersih:</span>
                            <strong>~Rp8.736.000</strong>
                        </div>

                    </div>

                </div>

                <div class="income-comparison">

                    <div class="comparison-other">
                        <strong>⊗</strong>
                        <span>
                            Aplikasi Lain: Terpotong
                            <b>20% - 30%</b>
                            <br>
                            (~Rp2.6 Juta/bulan)
                        </span>
                    </div>

                    <div class="comparison-voltara">
                        <strong>✓</strong>
                        <span>
                            Mitra VOLTARA:
                            <b>100% Hak Pengemudi</b>,
                            Rp0 komisi
                        </span>
                    </div>

                </div>

            </section>

            <!-- ARMADA -->
            <section class="fleet-card">

                <div class="fleet-heading">
                    <strong>ARMADA 4 RODA YANG MEMENUHI SYARAT</strong>
                    <span>● LIS BIRU EV INDONESIA</span>
                </div>

                <p>
                    VOLTARA CAR khusus memfasilitasi kendaraan listrik
                    berbasis baterai (BEV) dan hybrid modern demi
                    kenyamanan penumpang dan emisi nol.
                </p>

                <div class="fleet-brands">

                    <div>
                        <strong>Toyota</strong>
                        <span>Innova Zenix EV / HEV</span>
                    </div>

                    <div>
                        <strong>BYD</strong>
                        <span>M6 EV • Atto 3</span>
                    </div>

                    <div>
                        <strong>Hyundai</strong>
                        <span>Ioniq 5 • Kona EV</span>
                    </div>

                    <div>
                        <strong>Wuling</strong>
                        <span>Cloud EV • Binguo</span>
                    </div>

                </div>

            </section>

            <!-- TESTIMONI -->
            <section class="driver-testimonial">

                <div class="testimonial-avatar">HG</div>

                <div>
                    <div class="testimonial-heading">
                        <strong>Pak Hendra Gunawan</strong>
                        <span>Mitra Driver Surabaya</span>
                        <small>▣ L 2042 EV</small>
                    </div>

                    <p>
                        "Nyetir Zenix EV di VOLTARA enak banget.
                        Penumpang lebih menghargai armada listrik,
                        nego harga fair, dan uang ongkos langsung
                        saya terima tunai di tempat tanpa nunggu
                        dicairkan admin."
                    </p>
                </div>

            </section>

        </div>

        <!-- PANEL LOGIN DRIVER -->
        <aside class="driver-right">

            <div class="driver-login-card">

                <!-- SWITCH ROLE -->
             <div class="driver-role-switch">

    <button type="button" class="switch-option" disabled>
        Penumpang
    </button>

    <button type="button" class="switch-option active" disabled>
        Driver
    </button>

</div>

                <span class="driver-secure-badge">
                    ◉ MASUK CEPAT & AMAN
                </span>

                <h2>Mulai Perjalanan Hijau</h2>

                <p class="driver-login-description">
                    Masukkan nomor WhatsApp atau HP aktifmu.
                    Kami akan mengirimkan kode verifikasi OTP
                    langsung tanpa repot kata sandi.
                </p>

                <?php if ($error): ?>
                    <div class="driver-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form
                    method="POST"
                    action="<?= $base ?>/views/pages/driver-verifikasi.php"
                    class="driver-login-form"
                >

                    <!-- NOMOR HP -->
                    <div class="driver-field-heading">
                        <label for="driver-phone">Nomor Handphone</label>
                        <span>WhatsApp / SMS</span>
                    </div>

                    <div class="driver-phone-input">

                        <div class="country-code">
                            <span>🇮🇩</span>
                            <strong>+62</strong>
                            <span class="country-arrow">⌄</span>
                        </div>

                        <input
                            type="tel"
                            id="driver-phone"
                            name="phone"
                            placeholder="812-3456-7890"
                            value="<?= htmlspecialchars($phone) ?>"
                            required
                        >

                        <span class="phone-valid">✓</span>

                    </div>

                    <small class="driver-phone-hint">
                        ▣ Pastikan nomor terhubung dengan WhatsApp
                        atau SMS aktif.
                    </small>

                    <!-- METODE OTP -->
                    <div class="otp-heading">
                        Pilih Jalur Pengiriman OTP:
                    </div>

                    <div class="otp-methods">

                        <label class="otp-method selected">

                            <input
                                type="radio"
                                name="otp_method"
                                value="whatsapp"
                                checked
                            >

                            <span class="otp-method-icon">▤</span>

                            <span class="otp-method-text">
                                <strong>Via WhatsApp</strong>
                                <small>Instan · Disarankan</small>
                            </span>

                        </label>

                        <label class="otp-method">

                            <input
                                type="radio"
                                name="otp_method"
                                value="sms"
                            >

                            <span class="otp-method-icon sms-icon">▤</span>

                            <span class="otp-method-text">
                                <strong>Via SMS Biasa</strong>
                                <small>Standar Operator</small>
                            </span>

                        </label>

                    </div>

                    <button type="submit" class="driver-submit">
                        Lanjutkan & Kirim OTP
                    </button>

                </form>

                <!-- DAFTAR / MASUK -->
                <div class="driver-register-login">
                    <strong>Belum punya akun?</strong>
                    <a href="<?= $base ?>/views/pages/driver-register.php">
                        Daftar
                    </a>
                    sekarang.
                </div>

                <div class="driver-terms">
                    Dengan melanjutkan, kamu menyetujui
                    <a href="#">Syarat & Ketentuan</a>
                    serta
                    <a href="#">Kebijakan Privasi</a>
                    VOLTARA.
                </div>

            </div>

        </aside>

    </section>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
