<?php
// controllers/landing_controller.php
function landingIndex()
{
    render('landing', [
        'pageTitle'  => 'Beranda',
        'activePage' => 'landing',
        'extraCss'   => ['landing.css'],
    ]);
}