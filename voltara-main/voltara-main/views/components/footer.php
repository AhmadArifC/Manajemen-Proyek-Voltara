<?php
/**
 * views/components/footer.php
 * Hanya potongan footer, dipanggil oleh layouts/main.php.
 * Class CSS mengikuti public/css/landing.css (.footer, .footer-top, .footer-bottom, dst).
 */
?>
<footer class="footer">

    <div class="footer-top">

        <div class="footer-brand">
            <h3>VOLTARA <span>100% ELECTRIC</span></h3>
            <p>
                Layanan transportasi online ramah lingkungan berbasis kendaraan listrik.
                Solusi mobilitas urban cepat, bersih, dan hemat untuk kota masa depan.
            </p>
        </div>

        <div class="cash-info">
            <strong>Tunai ke Driver (Cash Only)</strong>
            <p>
                Sistem tarif pasti &amp; transparan langsung dibayar tunai saat tiba di tujuan.
                Bebas biaya admin tersembunyi.
            </p>
        </div>

        <div class="emission-info">
            <small>SERTIFIKASI EMISI</small>
            <strong>Zero Carbon Mobility</strong>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> VOLTARA Mobilitas Bersih Indonesia. Seluruh hak cipta dilindungi.</p>

        <div>
            <a href="#">Ketentuan Layanan</a>
            <a href="#">Privasi</a>
            <a href="#">Standar Emisi Hijau</a>
        </div>
    </div>

</footer>