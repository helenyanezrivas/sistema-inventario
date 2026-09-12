<?php

require_once __DIR__ . "/session.php";

/*
|--------------------------------------------------------------------------
| Seguridad del sistema
|--------------------------------------------------------------------------
| Funciones relacionadas con protección CSRF y cabeceras de seguridad.
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| CABECERAS DE SEGURIDAD
|--------------------------------------------------------------------------
| Se envían antes de cualquier contenido HTML.
|--------------------------------------------------------------------------
*/

if (!headers_sent()) {

    header(
        "X-Content-Type-Options: nosniff"
    );

    header(
        "X-Frame-Options: SAMEORIGIN"
    );

    header(
        "Referrer-Policy: strict-origin-when-cross-origin"
    );

    header(
        "Permissions-Policy: geolocation=(), camera=(), microphone=()"
    );
}


/**
 * Validar que la sesión pertenezca a un usuario activo.
 */
function validar_sesion_activa($conexion, $urlLogin)
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        iniciar_sesion_segura();
    }

    $usuarioId = (int) ($_SESSION["usuario_id"] ?? 0);

    if ($usuarioId <= 0) {
        header("Location: " . $urlLogin);
        exit;
    }

    $sql = "
        SELECT
            id,
            nombre,
            usuario,
            email,
            rol,
            estado
        FROM usuarios
        WHERE id = ?
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        http_response_code(503);
        exit("No fue posible validar la sesión.");
    }

    $stmt->bind_param("i", $usuarioId);

    if (!$stmt->execute()) {
        $stmt->close();
        http_response_code(503);
        exit("No fue posible validar la sesión.");
    }

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    $stmt->close();

    if (!$usuario || (int) $usuario["estado"] !== 1) {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                "",
                [
                    "expires" => time() - 42000,
                    "path" => $params["path"],
                    "domain" => $params["domain"],
                    "secure" => $params["secure"],
                    "httponly" => $params["httponly"],
                    "samesite" => $params["samesite"] ?? "Lax"
                ]
            );
        }

        session_destroy();

        header("Location: " . $urlLogin);
        exit;
    }

    $_SESSION["usuario_id"] = (int) $usuario["id"];
    $_SESSION["nombre"] = $usuario["nombre"];
    $_SESSION["usuario"] = $usuario["usuario"];
    $_SESSION["email"] = $usuario["email"];
    $_SESSION["rol"] = $usuario["rol"];
}


/**
 * Generar o recuperar el token CSRF de la sesión.
 */
function csrf_token()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        iniciar_sesion_segura();
    }

    if (empty($_SESSION["csrf_token"])) {
        $_SESSION["csrf_token"] = bin2hex(
            random_bytes(32)
        );
    }

    return $_SESSION["csrf_token"];
}


/**
 * Generar el campo oculto que se incluirá en los formularios.
 */
function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(
            csrf_token(),
            ENT_QUOTES,
            "UTF-8"
        )
        . '">';
}


/**
 * Verificar el token CSRF recibido.
 */
function verificar_csrf()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        iniciar_sesion_segura();
    }

    $tokenSesion = $_SESSION["csrf_token"] ?? "";
    $tokenFormulario = $_POST["csrf_token"] ?? "";

    if (
        empty($tokenSesion) ||
        empty($tokenFormulario) ||
        !hash_equals(
            $tokenSesion,
            $tokenFormulario
        )
    ) {

        http_response_code(403);

        die(
            "Solicitud no válida. "
            . "El token de seguridad no coincide."
        );
    }
}

?>
