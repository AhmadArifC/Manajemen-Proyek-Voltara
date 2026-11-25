<?php
function loginForm()
{
    render('login', [
        'pageTitle' => 'Masuk',
        'extraCss'  => ['login.css'],
    ]);
}