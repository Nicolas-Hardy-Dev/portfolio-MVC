<?php

namespace App\Core;

class CsrfToken
{
    public static function generate() : string
    {
        $_SESSION['token'] = bin2hex(random_bytes(32));
        $_SESSION['token_time'] = time();
        return ($_SESSION['token']);
    }

    public static function verify() : string
    {
        if (!isset($_POST['token'], $_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
            return "Token invalide";
        } elseif ($_SESSION['token_time'] <= time() - (10 * 60)) {
            return "Token expiré";
        } else {
            return "";
        }
    }
}