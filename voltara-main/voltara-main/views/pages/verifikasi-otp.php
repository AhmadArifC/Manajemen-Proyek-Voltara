<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/voltara-app';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $otpCode = trim($_POST['otp_code'] ?? '');

    if (!preg_match('/^[0-9]{4}$/', $otpCode)) {
        $_SESSION['otp_error'] = 'Masukkan 4 digit kode OTP.';
        header('Location: ' . $base . '/views/pages/verifikasi-otp.php');
        exit;
    }

    // MODE UJI COBA: semua 4 digit diterima
    $_SESSION['otp_verified'] = true;

    header('Location: ' . $base . '/views/pages/register-profile.php');
    exit;
}

$pageTitle = 'VOLTARA - Verifikasi OTP';
$pageCss = 'verifikasi-otp.css';
$activePage = '';

$showHeader = false;
$showFooter = false;

$phoneNumber = $_SESSION['pending_phone'] ?? '+62 812-3456-7890';

?>

<div class="otp-page">

    <div class="otp-card">

        <!-- TOP NAVIGATION -->
        <div class="otp-top">

            <a href="register-verifikasi.php" class="change-number">
                <span>←</span>
                GANTI NOMOR
            </a>

            <span class="electric-badge">
                ⚡ 100% ELECTRIC
            </span>

        </div>


        <!-- HEADER -->
        <div class="otp-heading">

            <span class="security-badge">
                ◈ VERIFIKASI KEAMANAN
            </span>

            <h1>Masukkan 4 Digit Kode OTP</h1>

            <p>
                Kode telah dikirim melalui WhatsApp & SMS ke
            </p>

            <span class="otp-phone">
                <?= htmlspecialchars($phoneNumber) ?>
                <span>↗</span>
            </span>

        </div>


        <!-- OTP FORM -->
        <form class="otp-form" method="POST" action="">

            <div class="otp-inputs">

                <input
                    type="text"
                    class="otp-digit"
                    inputmode="numeric"
                    maxlength="1"
                    autocomplete="one-time-code"
                    aria-label="Digit OTP pertama"
                    required
                    autofocus
                >

                <input
                    type="text"
                    class="otp-digit"
                    inputmode="numeric"
                    maxlength="1"
                    aria-label="Digit OTP kedua"
                    required
                >

                <input
                    type="text"
                    class="otp-digit"
                    inputmode="numeric"
                    maxlength="1"
                    aria-label="Digit OTP ketiga"
                    required
                >

                <input
                    type="text"
                    class="otp-digit"
                    inputmode="numeric"
                    maxlength="1"
                    aria-label="Digit OTP keempat"
                    required
                >

            </div>

            <input type="hidden" name="otp_code" id="otpCode">


            <!-- OTP STATUS -->
            <div class="otp-status" id="otpStatus">
                <span>✓</span>
                Kode OTP lengkap terdeteksi
            </div>


            <!-- RESEND TIMER -->
            <div class="otp-resend">

                <p>
                    ◷ Kirim ulang kode dalam
                    <strong id="countdown">00:48</strong>
                </p>

                <button
                    type="button"
                    id="resendOtp"
                    class="resend-button"
                    disabled
                >
                    Kirim ulang kode
                </button>

            </div>


            <button
                type="button"
                class="sms-fallback"
                id="smsFallback"
            >
                Kirim via SMS biasa jika WhatsApp terkendala
            </button>


            <!-- CASH INFORMATION -->
            <div class="otp-cash-info">

                <span class="cash-icon">▣</span>

                <div class="cash-text">
                    <strong>Tunai ke Driver</strong>
                    <p>Deal harganya langsung di jalan</p>
                </div>

                <span class="cash-badge">100% CASH</span>

            </div>


            <!-- SUBMIT -->
            <button type="submit" class="otp-submit">
                Verifikasi & Lanjutkan
            </button>


            <!-- FOOTER NOTES -->
            <div class="otp-security-note">
                <span>♙</span>
                Bebas password dan repot. Kerahasiaan data dijamin aman.
            </div>

            <div class="otp-emission">
                <span></span>
                0 Gram Emisi Perjalanan Bersama Voltara
            </div>

        </form>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const inputs = document.querySelectorAll('.otp-digit');
    const hiddenCode = document.getElementById('otpCode');
    const status = document.getElementById('otpStatus');
    const form = document.querySelector('.otp-form');

    function updateOtp() {

        const code = Array.from(inputs)
            .map(input => input.value)
            .join('');

        hiddenCode.value = code;

        const complete = code.length === 4;

        status.classList.toggle('complete', complete);

        return complete;
    }

    inputs.forEach((input, index) => {

        input.addEventListener('input', function () {

            this.value = this.value.replace(/\D/g, '').slice(0, 1);

            if (this.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            updateOtp();

        });

        input.addEventListener('keydown', function (event) {

            if (
                event.key === 'Backspace' &&
                !this.value &&
                index > 0
            ) {
                inputs[index - 1].focus();
            }

        });

        input.addEventListener('paste', function (event) {

            event.preventDefault();

            const pasted = (event.clipboardData || window.clipboardData)
                .getData('text')
                .replace(/\D/g, '')
                .slice(0, 4);

            pasted.split('').forEach((digit, i) => {
                inputs[i].value = digit;
            });

            const nextEmpty = Array.from(inputs)
                .find(input => !input.value);

            if (nextEmpty) {
                nextEmpty.focus();
            } else {
                inputs[3].focus();
            }

            updateOtp();

        });

    });


    // Countdown tampilan
    let seconds = 48;

    const countdown = document.getElementById('countdown');
    const resendButton = document.getElementById('resendOtp');

    const timer = setInterval(function () {

        seconds--;

        const minute = String(Math.floor(seconds / 60)).padStart(2, '0');
        const second = String(seconds % 60).padStart(2, '0');

        countdown.textContent = minute + ':' + second;

        if (seconds <= 0) {
            clearInterval(timer);
            countdown.textContent = '00:00';
            resendButton.disabled = false;
        }

    }, 1000);


    resendButton.addEventListener('click', function () {
        // Hubungkan ke proses pengiriman OTP ulang.
        alert('Fitur kirim ulang OTP perlu dihubungkan ke backend.');
    });

    document.getElementById('smsFallback').addEventListener('click', function () {
        // Hubungkan ke proses pengiriman OTP melalui SMS.
        alert('Fitur pengiriman SMS perlu dihubungkan ke backend.');
    });


    form.addEventListener('submit', function (event) {

        if (!updateOtp()) {
            event.preventDefault();
            alert('Masukkan 4 digit kode OTP terlebih dahulu.');
        }

    });

});
</script>


<?php

$content = ob_get_clean();

require __DIR__ . '/../layouts/main.php';

?>
