<?php

function iniciar_sesion_segura()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $esHttps =
        (!empty($_SERVER["HTTPS"])
        && $_SERVER["HTTPS"] !== "off")
        || (int) ($_SERVER["SERVER_PORT"] ?? 0) === 443;

    ini_set("session.use_strict_mode", "1");

    session_set_cookie_params([
        "lifetime" => 0,
        "path" => "/",
        "secure" => $esHttps,
        "httponly" => true,
        "samesite" => "Lax"
    ]);

    session_start();
}

?>
