<?php
// helpers/functions.php
// Fungsi bantu yang dipakai semua controller.

/**
 * Menampilkan halaman dengan kerangka layouts/main.php.
 *
 * @param string $view  nama file di views/pages/ tanpa .php   contoh: 'landing', 'login'
 * @param array  $data  variabel untuk halaman, contoh:
 *                      ['pageTitle' => 'Beranda', 'activePage' => 'landing', 'extraCss' => ['landing.css']]
 */
function render($view, $data = [])
{
    extract($data);

    $viewFile = __DIR__ . '/../views/pages/' . $view . '.php';

    if (!is_file($viewFile)) {
        http_response_code(404);
        exit('View tidak ditemukan: ' . htmlspecialchars($view));
    }

    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    require __DIR__ . '/../views/layouts/main.php';
}