<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/voltara-app';

// Proses ketika tombol Lanjutkan diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $countryCode = $_POST['country_code'] ?? '+62';
    $phone = trim($_POST['phone'] ?? '');

    if ($phone === '') {
        header('Location: login.php');
        exit;
    }

    // Simpan nomor HP untuk halaman OTP
    $_SESSION['pending_phone'] = $countryCode . ' ' . $phone;

    // Pindah ke halaman verifikasi OTP
    header('Location: verifikasi-otp.php');
    exit;
}

$pageTitle  = "VOLTARA - Masuk";
$pageCss    = 'login.css';
$activePage = 'beranda';
$isLoginPage = true;

ob_start();

?>

<div class="login-page">

    <div class="login-container">

        <!-- ================= LEFT CONTENT ================= -->

        <section class="login-intro">

            <div class="intro-content">

                <span class="intro-badge">
                    ♧ 100% ARMADA LISTRIK & BEBAS ASAP
                </span>

                <h1>
                    Masuk & Nikmati Tarif Bersih
                    Tanpa Tekanan Algoritma.
                </h1>

                <p class="intro-description">
                    Tentukan tarif perjalananmu sendiri, negosiasi langsung
                    dengan mitra driver EV, dan bayar tunai di tujuan
                    dengan bebas beban.
                </p>

                <!-- BENEFITS -->

                <div class="intro-benefits">

                    <div class="benefit-card">

                        <span class="benefit-icon lime">
                            ♧
                        </span>

                        <strong>Tawar Langsung</strong>

                        <p>
                            Kesepakatan harga adil dua arah.
                        </p>

                    </div>

                    <div class="benefit-card">

                        <span class="benefit-icon mint">
                            ◈
                        </span>

                        <strong>Bebas Polusi</strong>

                        <p>
                            Hemat emisi karbon nyata di tiap km.
                        </p>

                    </div>

                    <div class="benefit-card">

                        <span class="benefit-icon lime">
                            ▣
                        </span>

                        <strong>Tanpa Admin</strong>

                        <p>
                            Bayar cash pas langsung ke driver.
                        </p>

                    </div>

                </div>

                <!-- VEHICLE IMAGE -->

                <div class="intro-image">

                    <img
                        src="<?= $base ?>/public/img/voltara-car.jpg"
                        alt="Armada mobil listrik VOLTARA"
                    >

                    <span class="image-top-badge">
                        ⚡ DEAL HARGANYA, CLEAN JALANNYA
                    </span>

                    <span class="image-bottom-badge">
                        🚘 VOLTARA CAR
                    </span>

                </div>

            </div>

        </section>


        <!-- ================= RIGHT LOGIN FORM ================= -->

        <section class="login-form-section">

            <div class="login-form-header">

                <span class="form-badge">
                    ♧ MASUK CEPAT & AMAN
                </span>

                <h2>
                    Mulai Perjalanan Hijau
                </h2>

                <p>
                    Masukkan nomor WhatsApp atau HP aktifmu.
                    Kami akan mengirimkan kode verifikasi OTP
                    langsung tanpa repot kata sandi.
                </p>

            </div>


            <!-- LOGIN FORM -->

            <form class="otp-form" action="#" method="POST">

                <!-- PHONE NUMBER -->

                <div class="form-label-row">

                    <label for="phone">
                        Nomor Handphone
                    </label>

                    <span>WhatsApp / SMS</span>

                </div>


                <div class="phone-input">

                    <span class="country-flag">
                        🇮🇩
                    </span>

                    <select name="country_code"
                            aria-label="Kode negara">

                        <option value="+62">+62</option>

                    </select>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="812-3456-7890"
                        required
                    >

                    <span class="phone-check">
                        ✓
                    </span>

                </div>


                <div class="phone-hint">

                    <span>▤</span>

                    <p>
                        Pastikan nomor terhubung dengan WhatsApp
                        atau SMS aktif.
                    </p>

                </div>


                <!-- OTP METHOD -->

                <div class="otp-method">

                    <strong class="method-title">
                        Pilih Jalur Pengiriman OTP:
                    </strong>

                    <div class="method-options">

                        <label class="method-option selected">

                            <input
                                type="radio"
                                name="otp_method"
                                value="whatsapp"
                                checked
                            >

                            <span class="method-icon">
                                ▤
                            </span>

                            <span class="method-text">

                                <strong>Via WhatsApp</strong>

                                <small>Instan • Disarankan</small>

                            </span>

                        </label>


                        <label class="method-option">

                            <input
                                type="radio"
                                name="otp_method"
                                value="sms"
                            >

                            <span class="method-icon sms-icon">
                                ▤
                            </span>

                            <span class="method-text">

                                <strong>Via SMS Biasa</strong>

                                <small>Standar Operator</small>

                            </span>

                        </label>

                    </div>

                </div>


                <!-- PAYMENT INFORMATION -->

                <div class="payment-info">

                    <span class="payment-icon">
                        ▣
                    </span>

                    <div>

                        <strong>
                            TUNAI LANGSUNG KE DRIVER
                        </strong>

                        <p>
                            Tanpa perlu kartu kredit atau saldo
                            tersangkut. Negosiasi dan bayar tunai pas.
                        </p>

                    </div>

                </div>


                <!-- SUBMIT -->

                <button type="submit" class="otp-submit">

                    Lanjutkan & Kirim OTP

                </button>


                <!-- TERMS -->

                <div class="form-terms">

                    <p>
                        <strong>Belum punya akun?</strong>
                        Cukup masukkan nomor HP di atas,
                        akun barumu akan otomatis dibuat setelah
                        verifikasi kode OTP.
                    </p>

                    <p>
                        Dengan melanjutkan, kamu menyetujui
                        <a href="#">Syarat & Ketentuan</a>
                        serta
                        <a href="#">Kebijakan Privasi</a>
                        VOLTARA.
                    </p>

                </div>

            </form>

        </section>

    </div>

</div>


<?php

$content = ob_get_clean();

require __DIR__ . '/../layouts/main.php';

?>
