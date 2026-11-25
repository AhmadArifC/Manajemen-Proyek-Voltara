
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/voltara-app';

// Harus verifikasi OTP terlebih dahulu
if (empty($_SESSION['otp_verified'])) {
    header('Location: ' . $base . '/views/pages/verifikasi-otp.php');
    exit;
}

// Ambil pilihan role dari tahap verifikasi sebelumnya
$selectedRole = $_SESSION['pending_role'] ?? 'penumpang';

// Pastikan pilihan role valid
if (!in_array($selectedRole, ['penumpang', 'driver'], true)) {
    $selectedRole = 'penumpang';
}

// Proses penyimpanan profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $phone = $_SESSION['pending_phone'] ?? '';
    $quietRide = isset($_POST['quiet_ride']);

    // Ambil pilihan role dari tombol yang dipilih
    $accountType = $_POST['account_type'] ?? $selectedRole;

    if (!in_array($accountType, ['penumpang', 'driver'], true)) {
        $accountType = 'penumpang';
    }

    if ($name === '' || !isset($_POST['terms'])) {
        $_SESSION['register_error'] = 'Nama dan persetujuan wajib diisi.';
        $_SESSION['pending_role'] = $accountType;

        header('Location: register-profile.php');
        exit;
    }

    // Simpan data pengguna ke session
    $_SESSION['user'] = [
    'name' => $name,
    'phone' => $phone,
    'role' => 'user',
    'account_type' => 'penumpang',
    'status' => 'Pelanggan',
    'quiet_ride' => $quietRide
];

    unset($_SESSION['pending_phone']);
    unset($_SESSION['pending_role']);
    unset($_SESSION['otp_verified']);
    unset($_SESSION['otp_method']);
    unset($_SESSION['register_error']);

    // Masuk ke landing page setelah registrasi
    header('Location: landing.php');
    exit;
}

$pageTitle = 'VOLTARA - Buat Profil User';
$pageCss = 'register-profile.css';
$activePage = 'beranda';

$isLoginPage = false;
$showHeader = true;
$showFooter = true;

$phoneNumber = $_SESSION['pending_phone'] ?? '+62 812-3456-7890';
$error = $_SESSION['register_error'] ?? '';

unset($_SESSION['register_error']);

ob_start();
?>

<div class="register-profile-page">

    <!-- PROGRESS -->
    <div class="register-progress">
        <div class="progress-step completed">
            <span class="step-number">✓</span>
            <strong>1. Verifikasi Nomor HP</strong>
        </div>

        <span class="progress-arrow">→</span>

        <div class="progress-step active">
            <span class="step-number">2</span>
            <strong>2. Buat Profil User</strong>
            <span class="active-label">AKTIF</span>
        </div>

        <span class="progress-info">
            ◴ Hanya butuh 30 detik untuk selesai!
        </span>
    </div>

    <div class="register-profile-grid">

        <!-- FORM PROFIL -->
        <section class="profile-form-card">

            <!-- PILIHAN ROLE -->
            <div class="role-tabs">

    <button type="button" class="role-tab selected" disabled>
        User
    </button>

    <button type="button" class="role-tab" disabled>
        Driver
    </button>

</div>

            <div class="profile-heading">
                <span class="new-user-badge">
                    ◈ PENGGUNA BARU VOLTARA
                </span>
                <span class="last-step">· Langkah Terakhir</span>

                <h1>Kenalan dulu, yuk!</h1>

                <p>
                    Cukup masukkan nama panggilan atau nama lengkapmu
                    agar driver armada EV bisa menyapamu dengan ramah
                    saat penjemputan.
                </p>
            </div>

            <?php if ($error): ?>
                <div class="register-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="profile-form">

                <!-- ROLE YANG DIPILIH -->
                <input
                    type="hidden"
                    name="account_type"
                    id="accountType"
                    value="<?= htmlspecialchars($selectedRole) ?>"
                >

                <!-- NOMOR HP -->
                <div class="field-heading">
                    <label>Nomor Handphone</label>
                    <span class="verified-label">◉ Terverifikasi OTP</span>
                </div>

                <div class="verified-phone">
                    <span>▯</span>
                    <strong>
                        <?= htmlspecialchars($phoneNumber) ?>
                    </strong>
                    <span class="verified-check">✓</span>
                </div>

                <!-- NAMA -->
                <div class="profile-field">
                    <label for="name">
                        Nama Lengkap / Panggilan User
                        <span>*</span>
                    </label>

                    <div class="name-input">
                        <span>♙</span>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="User"
                            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                            maxlength="60"
                            required
                        >
                    </div>

                    <small class="field-hint">
                        ⓘ Nama ini akan ditampilkan langsung kepada driver
                        EV saat proses negosiasi dan titik jemput.
                    </small>
                </div>

                <!-- AVATAR -->
                <div class="avatar-section">
                    <div class="avatar-heading">
                        <label>Pilih Karakter Avatar atau Foto</label>
                        <small>Opsional</small>
                    </div>

                    <label for="avatar" class="avatar-upload">
                        <span class="camera-icon">▧</span>
                        <span>Unggah</span>
                    </label>

                    <input
                        type="file"
                        id="avatar"
                        name="avatar"
                        accept="image/*"
                        hidden
                    >
                </div>

                <!-- PREFERENSI -->
                <div class="preference-section">
                    <label class="preference-title">
                        Preferensi Kenyamanan EV (Opsional)
                    </label>

                    <label class="quiet-option">
                        <span class="quiet-icon">◉</span>

                        <span class="quiet-description">
                            <strong>Mode Perjalanan Tenang (Quiet Ride)</strong>
                            <small>
                                Driver hanya berbicara untuk hal konfirmasi
                                rute penting.
                            </small>
                        </span>

                        <input
                            type="checkbox"
                            name="quiet_ride"
                            value="1"
                        >
                    </label>
                </div>

                <!-- TERMS -->
                <label class="terms-option">
                    <input type="checkbox" name="terms" required>

                    <span>
                        Saya menyetujui
                        <a href="#">Syarat & Ketentuan Penggunaan</a>
                        dan
                        <a href="#">Kebijakan Privasi</a>
                        VOLTARA.
                    </span>
                </label>

                <!-- SUBMIT -->
                <button type="submit" class="profile-submit">
                    Mulai Perjalanan Pertama <span>⚡</span>
                </button>

                <p class="profile-note">
                    Kamu bisa memperbarui foto atau data profilmu kapan saja
                    di menu <strong>Akun</strong>.
                </p>

            </form>
        </section>

        <!-- PANEL KANAN -->
        <aside class="register-side">

            <section class="cash-promo">

                <span class="cash-promo-badge">
                    ▣ 100% PEMBAYARAN TUNAI
                </span>

                <h2>Deal Harganya, Langsung Bayar di Tempat.</h2>

                <p>
                    Tidak perlu repot hubungkan kartu kredit, e-wallet,
                    atau transfer bank. Tawar harga secara transparan,
                    sepakati tarif, lalu serahkan uang tunai langsung
                    ke tangan driver saat tiba di tujuan.
                </p>

                <div class="promo-features">

                    <div class="promo-feature">
                        <span class="feature-icon">♧</span>
                        <strong>Harga Pasti</strong>
                        <small>
                            Sesuai kesepakatan awal tanpa biaya tersembunyi.
                        </small>
                    </div>

                    <div class="promo-feature">
                        <span class="feature-icon">▣</span>
                        <strong>100% Listrik</strong>
                        <small>
                            Nol emisi knalpot, senyap dan bebas polusi.
                        </small>
                    </div>

                </div>
            </section>

            <section class="security-promo">

                <div class="security-top">
                    <span>◈ KEAMANAN AKUN</span>
                    <strong>Bebas Password</strong>
                </div>

                <h2>Akses Cepat & Aman Tanpa Kata Sandi</h2>

                <p>
                    VOLTARA menggunakan sistem login kode sekali pakai
                    (OTP) langsung ke nomor HP aktifmu. Tak perlu
                    menghafal atau khawatir kehilangan password akun.
                </p>

                <div class="security-stats">
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
                    <strong>PROTEKSI DATA USER</strong>
                    <span>Nomor telepon disamarkan saat proses penjemputan.</span>
                </div>

            </section>

        </aside>

    </div>
</div>

<!-- JAVASCRIPT UNTUK SWITCH ROLE -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleTabs = document.querySelectorAll('.role-tab');
    const accountType = document.getElementById('accountType');

    roleTabs.forEach(function (tab) {

        tab.addEventListener('click', function () {

            // Hapus selected dari semua tab
            roleTabs.forEach(function (item) {
                item.classList.remove('selected');
            });

            // Aktifkan tab yang diklik
            this.classList.add('selected');

            // Simpan pilihan ke input hidden
            accountType.value = this.dataset.role;

        });

    });

});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
