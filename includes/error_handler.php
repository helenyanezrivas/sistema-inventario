<?php

ini_set("log_errors", "1");
ini_set("display_errors", "0");

function registrar_error_tecnico($detalle)
{
    error_log("[Inventario] " . $detalle);
}

function abortar_error_tecnico($detalle)
{
    registrar_error_tecnico($detalle);
    http_response_code(500);
    exit("Ocurrió un error interno. Inténtalo nuevamente más tarde.");
}

function mensaje_error_tecnico($detalle)
{
    registrar_error_tecnico($detalle);

    return "Ocurrió un error interno. Inténtalo nuevamente más tarde.";
}

?>
