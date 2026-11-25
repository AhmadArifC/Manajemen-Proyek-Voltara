
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/voltara-app';

// Pilihan akun sebelumnya, default Penumpang
$selectedRole = $_SESSION['pending_role'] ?? 'penumpang';

// Proses tombol Lanjutkan & Kirim OTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $countryCode = $_POST['country_code'] ?? '+62';
    $phone = trim($_POST['phone'] ?? '');
    $otpMethod = $_POST['otp_method'] ?? 'whatsapp';
    $accountType = $_POST['account_type'] ?? 'penumpang';

    // Validasi jenis akun
    if (!in_array($accountType, ['penumpang', 'driver'], true)) {
        $_SESSION['error'] = 'Jenis akun tidak valid.';
        header('Location: register-verifikasi.php');
        exit;
    }

    // Validasi metode OTP
    if (!in_array($otpMethod, ['whatsapp', 'sms'], true)) {
        $otpMethod = 'whatsapp';
    }

    // Validasi nomor HP
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (empty($phone)) {
        $_SESSION['error'] = 'Nomor HP wajib diisi.';
        header('Location: register-verifikasi.php');
        exit;
    }

    // Simpan data sementara ke session
    $_SESSION['pending_phone'] = $countryCode . ' ' . $phone;
    $_SESSION['otp_method'] = $otpMethod;
    $_SESSION['pending_role'] = $accountType;

    // Pindah ke halaman OTP
    header('Location: verifikasi-otp.php');
    exit;
}

$pageTitle = 'VOLTARA - Verifikasi Nomor HP';
$pageCss = 'register-verifikasi.css';
$activePage = '';
$isLoginPage = true;

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

ob_start();

?>

<div class="verify-page">

    <div class="verify-container">

        <!-- PROGRESS -->
        <div class="verify-progress">

            <div class="progress-steps">

                <div class="progress-step active">
                    <span class="step-number">1</span>
                    <strong>1. Verifikasi Nomor HP</strong>
                    <span class="step-status">AKTIF</span>
                </div>

                <span class="step-arrow">→</span>

                <div class="progress-step">
                    <span class="step-number">2</span>
                    <strong>2. Buat Profil Diri</strong>
                </div>

            </div>

            <div class="progress-note">
                <span>◴</span>
                Hanya butuh 30 detik untuk verifikasi!
            </div>

        </div>

        <!-- CONTENT GRID -->
        <div class="verify-grid">

            <!-- LEFT: FORM -->
            <section class="verify-form-card">

                <!-- ACCOUNT TYPE -->
                <div class="account-tabs">

    <label class="account-tab selected">
        <input
            type="radio"
            name="account_type"
            value="penumpang"
            checked
            disabled
        >
        <span>Penumpang</span>
    </label>

    <label class="account-tab">
        <input
            type="radio"
            name="account_type"
            value="driver"
            disabled
        >
        <span>Driver</span>
    </label>

</div>

                <!-- FORM HEADER -->
                <div class="verify-heading">

                    <div class="verify-label">
                        <span>♧ PENGGUNA BARU VOLTARA</span>
                        <small>· Langkah 1 dari 2</small>
                    </div>

                    <h1>Verifikasi Nomor HP</h1>

                    <p>
                        Masukkan 4 digit kode OTP yang kami kirimkan
                        ke nomor WhatsApp / SMS kamu untuk
                        melanjutkan pembuatan akun.
                    </p>

                </div>

                <?php if ($error): ?>
                    <div class="register-error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- PHONE FORM -->
                <form
                    id="verifyForm"
                    class="verify-form"
                    action=""
                    method="POST"
                >

                    <div class="phone-label-row">
                        <label for="phone">Nomor Handphone</label>
                        <span>WhatsApp / SMS</span>
                    </div>

                    <div class="phone-field">

                        <span class="country-flag">🇮🇩</span>

                        <select
                            name="country_code"
                            aria-label="Kode negara"
                        >
                            <option value="+62">+62</option>
                        </select>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="812-3456-7890"
                            value="<?= htmlspecialchars($_SESSION['pending_phone'] ?? '812-3456-7890') ?>"
                            required
                        >

                        <span class="phone-valid">✓</span>

                    </div>

                    <div class="phone-hint">
                        <span>▤</span>
                        Pastikan nomor terhubung dengan WhatsApp
                        atau SMS aktif.
                    </div>

                    <!-- OTP METHOD -->
                    <div class="otp-method">

                        <strong class="otp-method-title">
                            Pilih Jalur Pengiriman OTP:
                        </strong>

                        <div class="otp-options">

                            <label class="otp-option selected">

                                <input
                                    type="radio"
                                    name="otp_method"
                                    value="whatsapp"
                                    <?= ($_SESSION['otp_method'] ?? 'whatsapp') === 'whatsapp' ? 'checked' : '' ?>
                                >

                                <span class="otp-icon">▤</span>

                                <span class="otp-option-text">
                                    <strong>Via WhatsApp</strong>
                                    <small>Instan · Disarankan</small>
                                </span>

                            </label>

                            <label class="otp-option">

                                <input
                                    type="radio"
                                    name="otp_method"
                                    value="sms"
                                    <?= ($_SESSION['otp_method'] ?? '') === 'sms' ? 'checked' : '' ?>
                                >

                                <span class="otp-icon sms">▤</span>

                                <span class="otp-option-text">
                                    <strong>Via SMS Biasa</strong>
                                    <small>Standar Operator</small>
                                </span>

                            </label>

                        </div>

                    </div>

                    <!-- PRIVACY INFO -->
                    <div class="privacy-note">

                        <span class="privacy-icon">♧</span>

                        <p>
                            Privasi dan keamanan nomor handphonemu
                            terjamin 100% aman dan bebas spam.
                        </p>

                    </div>

                    <!-- SUBMIT -->
                    <button
                        type="submit"
                        class="verify-submit"
                    >
                        Lanjutkan & Kirim OTP
                    </button>

                    <!-- ACCOUNT INFO -->
                    <div class="verify-account-info">

                        <p>
                            <strong>Sudah punya akun?</strong>
                            <a href="login.php">Login</a>
                            untuk masuk ke akun kamu.
                        </p>

                        <p class="verify-terms">
                            Dengan melanjutkan, kamu menyetujui
                            <a href="#">Syarat & Ketentuan</a>
                            serta
                            <a href="#">Kebijakan Privasi</a>
                            VOLTARA.
                        </p>

                    </div>

                </form>

            </section>

            <!-- RIGHT: INFORMATION -->
            <aside class="verify-sidebar">

                <!-- PAYMENT CARD -->
                <section class="payment-card">

                    <span class="payment-badge">
                        ▣ 100% PEMBAYARAN TUNAI
                    </span>

                    <h2>
                        Deal Harganya, Langsung
                        Bayar di Tempat.
                    </h2>

                    <p class="payment-description">
                        Tidak perlu repot hubungkan kartu kredit,
                        e-wallet, atau transfer bank. Tawar harga
                        secara transparan, sepakati tarif, lalu
                        serahkan uang tunai langsung ke tangan
                        driver saat tiba di tujuan.
                    </p>

                    <div class="payment-features">

                        <div class="payment-feature">

                            <span class="feature-icon dark">♧</span>

                            <strong>Harga Pasti</strong>

                            <p>
                                Sesuai kesepakatan awal tanpa
                                biaya tersembunyi.
                            </p>

                        </div>

                        <div class="payment-feature">

                            <span class="feature-icon lime">▣</span>

                            <strong>100% Listrik</strong>

                            <p>
                                Nol emisi knalpot, senyap
                                dan bebas polusi.
                            </p>

                        </div>

                    </div>

                </section>

                <!-- SECURITY CARD -->
                <section class="security-card">

                    <div class="security-header">

                        <div class="security-label">
                            <span class="security-icon">◈</span>
                            KEAMANAN AKUN
                        </div>

                        <span class="password-badge">
                            Bebas Password
                        </span>

                    </div>

                    <h3>
                        Akses Cepat & Aman Tanpa Kata Sandi
                    </h3>

                    <p class="security-description">
                        VOLTARA menggunakan sistem login kode
                        sekali pakai (OTP) langsung ke nomor HP
                        aktifmu. Tak perlu menghafal atau khawatir
                        kehilangan password akun.
                    </p>

                    <div class="security-stat">

                        <div>
                            <strong>0% Ribet</strong>
                            <small>Tanpa Simpan Sandi</small>
                        </div>

                        <div>
                            <strong>100%</strong>
                            <small>Cepat Masuk</small>
                        </div>

                    </div>

                    <div class="data-protection">

                        <strong>PROTEKSI DATA PENUMPANG</strong>

                        <p>
                            Nomor telepon disamarkan saat proses
                            penjemputan.
                        </p>

                    </div>

                </section>

            </aside>

        </div>

    </div>

</div>

<script>
document.querySelectorAll('.account-tab input').forEach(function (radio) {

    radio.addEventListener('change', function () {

        document.querySelectorAll('.account-tab').forEach(function (tab) {
            tab.classList.remove('selected');
        });

        this.closest('.account-tab').classList.add('selected');

    });

});
</script>

<?php

$content = ob_get_clean();

require __DIR__ . '/../layouts/main.php';

?>
