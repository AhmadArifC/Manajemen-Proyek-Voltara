
<?php
/**
 * views/layouts/main.php
 * Kerangka HTML untuk semua halaman di views/pages/.
 *
 * Cara pakai di halaman (contoh views/pages/landing.php):
 *
 *     $pageTitle  = "VOLTARA - Beranda";
 *     $pageCss    = "landing.css";
 *     $activePage = "beranda";
 *
 *     ob_start();
 *
 *     ... isi halaman (HTML) ...
 *
 *     $content = ob_get_clean();
 *
 *     require __DIR__ . '/../layouts/main.php';
 *
 * Variabel opsional:
 * $showHeader (default true)
 * $showFooter (default true)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========================================
// KONFIGURASI DASAR
// ========================================

$base       = '/voltara-app'; // Nama folder proyek di htdocs

$pageTitle  = $pageTitle  ?? 'VOLTARA';
$pageCss    = $pageCss    ?? 'landing.css';
$activePage = $activePage ?? '';

$content    = $content    ?? '';

$showHeader = $showHeader ?? true;
$showFooter = $showFooter ?? true;

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- CSS GLOBAL -->
    <link rel="stylesheet"
          href="<?= $base ?>/public/css/layout.css">

    <!-- CSS KHUSUS HALAMAN -->
    <link rel="stylesheet"
          href="<?= $base ?>/public/css/<?= htmlspecialchars($pageCss) ?>">

</head>

<body>


<!-- ========================================
     HEADER
========================================= -->

<?php

if ($showHeader) {
    require __DIR__ . '/../components/header.php';
}

?>


<!-- ========================================
     KONTEN UTAMA
========================================= -->

<main>

    <?= $content ?>

</main>


<!-- ========================================
     FOOTER
========================================= -->

<?php if ($showFooter) require __DIR__ . '/../components/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('profileToggle');
    const menu = document.getElementById('profileMenu');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
        const isOpen = menu.classList.toggle('show');

        toggle.classList.toggle('active', isOpen);
        toggle.setAttribute('aria-expanded', isOpen);
    });

    document.addEventListener('click', function (event) {
        if (!toggle.contains(event.target) &&
            !menu.contains(event.target)) {

            menu.classList.remove('show');
            toggle.classList.remove('active');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>

<!-- ========================================
     JAVASCRIPT NAVIGASI
========================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');
    const navbar = document.querySelector('.navbar');

    if (!menuToggle || !navMenu || !navbar) return;


    // ====================================
    // TOGGLE HAMBURGER
    // ====================================

    menuToggle.addEventListener('click', function (event) {

        event.stopPropagation();

        const isOpen = navMenu.classList.toggle('active');

        menuToggle.setAttribute(
            'aria-expanded',
            isOpen ? 'true' : 'false'
        );

    });


    // ====================================
    // MENCEGAH KLIK DI DALAM MENU
    // DIANGGAP KLIK DI LUAR
    // ====================================

    navMenu.addEventListener('click', function (event) {

        event.stopPropagation();

    });


    // ====================================
    // KLIK DI LUAR NAVBAR
    // UNTUK MENUTUP MENU
    // ====================================

    document.addEventListener('click', function (event) {

        if (!navbar.contains(event.target)) {

            navMenu.classList.remove('active');

            menuToggle.setAttribute(
                'aria-expanded',
                'false'
            );

        }

    });


    // ====================================
    // MENUTUP MENU SETELAH LINK DIPILIH
    // ====================================

    navMenu.querySelectorAll('a').forEach(function (link) {

        link.addEventListener('click', function () {

            navMenu.classList.remove('active');

            menuToggle.setAttribute(
                'aria-expanded',
                'false'
            );

        });

    });

});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const methods = document.querySelectorAll('.otp-method');

    methods.forEach(function (method) {

        method.addEventListener('click', function () {

            methods.forEach(function (item) {
                item.classList.remove('selected');
            });

            this.classList.add('selected');

            const radio = this.querySelector('input[type="radio"]');

            if (radio) {
                radio.checked = true;
            }

        });

    });

});
</script>

</body>
</html>
