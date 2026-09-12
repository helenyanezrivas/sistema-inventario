<?php

require_once __DIR__ . "/../includes/error_handler.php";

$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "inventario";

$conexion = new mysqli(
    $host,
    $usuario,
    $password,
    $base_datos
);

if ($conexion->connect_error) {
    abortar_error_tecnico("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

?>
