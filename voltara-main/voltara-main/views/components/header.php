<?php
/**
 * views/components/header.php
 */

$isLoginPage  = $isLoginPage ?? false;
$isDriverPage = $isDriverPage ?? false;
$isPublicPage = $isPublicPage ?? false;

// Halaman login tetap menampilkan navbar pengunjung.
// Halaman publik tetap bisa membaca session user.
$user = $isLoginPage
    ? null
    : ($_SESSION['user'] ?? null);
    
// Menu halaman publik
if ($isPublicPage || $isLoginPage) {

    $menu = [
        'beranda' => [
            'Beranda',
            $base . '/views/pages/landing.php'
        ],
        'cara-kerja' => [
            'Cara Kerja',
            $base . '/views/pages/landing.php#cara-kerja'
        ],
        'keunggulan' => [
            'Keunggulan',
            $base . '/views/pages/landing.php#keunggulan'
        ],
        'cara-voltara' => [
            'Cara Kerja VOLTARA',
            $base . '/views/pages/landing.php#pricing'
        ],
    ];

} else {

    $menu = [
        'beranda' => [
            'Beranda',
            $base . '/views/pages/landing.php'
        ],
        'pesan' => [
            'Pesan Kendaraan',
            $base . '/views/pages/order.php'
        ],
        'riwayat' => [
            'Riwayat Pemesanan',
            $base . '/views/pages/riwayat.php'
        ],
    ];
}

// Inisial nama pengguna
$initials = '';

if ($user) {
    foreach (
        array_slice(explode(' ', trim($user['name'])), 0, 2)
        as $word
    ) {
        $initials .= strtoupper(mb_substr($word, 0, 1));
    }
}
?>

<header class="navbar <?= $isLoginPage ? 'login-navbar' : '' ?>">
    <!-- LOGO -->
    <a href="<?= $base ?>/views/pages/landing.php" class="logo">
        VOLT<span>ARA</span>
    </a>

    <!-- HAMBURGER BUTTON -->
    <button
        type="button"
        class="menu-toggle"
        id="menuToggle"
        aria-label="Buka menu navigasi"
        aria-expanded="false"
        aria-controls="navMenu"
    >
        ☰
    </button>

    <!-- NAVIGATION MENU -->
    <nav class="nav-menu" id="navMenu">

        <?php foreach ($menu as $key => [$label, $link]): ?>

            <a href="<?= $link ?>"
               class="<?= $activePage === $key ? 'active' : '' ?>">

                <?= htmlspecialchars($label) ?>

            </a>

        <?php endforeach; ?>

        <?php if ($user && !$isLoginPage && !$isDriverPage): ?>

    <a href="<?= $base ?>/views/pages/driver.php"
       class="driver-mode">

        Mode Pengemudi

    </a>

<?php endif; ?>

    </nav>

    <!-- PROFILE / LOGIN -->
    <div class="nav-profile">
        
<?php if ($isLoginPage || !$user): ?>
    
            <a href="<?= $base ?>/views/pages/login.php"
               class="nav-register">

                Daftar

            </a>

            <a href="<?= $base ?>/views/pages/login.php"
               class="nav-login">

                <span>⇥</span> Masuk / Login

            </a>

        <?php elseif ($user): ?>

            <button type="button"
                    class="notification"
                    aria-label="Notifikasi">

                <svg class="icon-bell"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     stroke-linecap="round"
                     stroke-linejoin="round">

                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>

                </svg>

            </button>

            <div class="profile-dropdown">

    <button type="button"
            class="profile profile-trigger"
            id="profileToggle"
            aria-expanded="false"
            aria-controls="profileMenu">

        <div class="profile-avatar">
            <?= htmlspecialchars($initials) ?>
        </div>

        <div class="profile-info">
            <strong>
                <?= htmlspecialchars($user['name']) ?>
            </strong>

            <small>
                <?= htmlspecialchars($user['status'] ?? 'Pelanggan') ?>
            </small>
        </div>

        <svg class="profile-chevron"
             width="14"
             height="14"
             viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2.2"
             stroke-linecap="round"
             stroke-linejoin="round">

            <path d="m6 9 6 6 6-6"/>
        </svg>

    </button>

    <div class="profile-menu" id="profileMenu">

        <a href="<?= $base ?>/views/pages/landing.php?logout=1">
            <span>↪</span>
            Logout
        </a>

    </div>

</div>

        <?php else: ?>

            <a href="<?= $base ?>/views/pages/login.php"
               class="nav-login">

                Masuk / Login

            </a>

        <?php endif; ?>

    </div>

</header>
