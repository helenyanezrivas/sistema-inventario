<?php

$baseUrl = "/inventario";
$rutaActual = $_SERVER["SCRIPT_NAME"] ?? "";
$moduloActual = "dashboard";

if (strpos($rutaActual, "/views/productos/") !== false) {
    $moduloActual = "productos";
} elseif (strpos($rutaActual, "/views/categorias/") !== false) {
    $moduloActual = "categorias";
} elseif (strpos($rutaActual, "/views/ventas/") !== false) {
    $moduloActual = "ventas";
} elseif (strpos($rutaActual, "/views/usuarios/") !== false) {
    $moduloActual = "usuarios";
}

$rolActual = $_SESSION["rol"] ?? "";

?>

<nav class="navbar navbar-expand-lg navbar-dark navbar-app">

    <div class="container-fluid px-4">

        <a
            href="<?php echo $baseUrl; ?>/index.php"
            class="navbar-brand navbar-app-brand"
        >
            <i class="bi bi-box-seam"></i>
            <span>Sistema de Inventario</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-navbar-toggle
            aria-controls="navegacionPrincipal"
            aria-expanded="false"
            aria-label="Mostrar navegación"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navegacionPrincipal">

            <ul class="navbar-nav navbar-modulos ms-lg-4">

                <li class="nav-item">
                    <a
                        href="<?php echo $baseUrl; ?>/index.php"
                        class="nav-link navbar-module <?php echo $moduloActual === "dashboard" ? "active" : ""; ?>"
                        <?php echo $moduloActual === "dashboard" ? 'aria-current="page"' : ""; ?>
                    >
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="<?php echo $baseUrl; ?>/views/productos/listar.php"
                        class="nav-link navbar-module <?php echo $moduloActual === "productos" ? "active" : ""; ?>"
                        <?php echo $moduloActual === "productos" ? 'aria-current="page"' : ""; ?>
                    >
                        <i class="bi bi-box-seam"></i>
                        Productos
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="<?php echo $baseUrl; ?>/views/categorias/listar.php"
                        class="nav-link navbar-module <?php echo $moduloActual === "categorias" ? "active" : ""; ?>"
                        <?php echo $moduloActual === "categorias" ? 'aria-current="page"' : ""; ?>
                    >
                        <i class="bi bi-tags"></i>
                        Categorías
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        href="<?php echo $baseUrl; ?>/views/ventas/listar.php"
                        class="nav-link navbar-module <?php echo $moduloActual === "ventas" ? "active" : ""; ?>"
                        <?php echo $moduloActual === "ventas" ? 'aria-current="page"' : ""; ?>
                    >
                        <i class="bi bi-cart-check"></i>
                        Ventas
                    </a>
                </li>

                <?php if ($rolActual === "admin"): ?>

                    <li class="nav-item">
                        <a
                            href="<?php echo $baseUrl; ?>/views/usuarios/listar.php"
                            class="nav-link navbar-module <?php echo $moduloActual === "usuarios" ? "active" : ""; ?>"
                            <?php echo $moduloActual === "usuarios" ? 'aria-current="page"' : ""; ?>
                        >
                            <i class="bi bi-people"></i>
                            Usuarios
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

            <div class="navbar-session ms-lg-auto">

                <div class="navbar-user-info">
                    <i class="bi bi-person-circle"></i>

                    <span class="navbar-user-name">
                        <?php echo htmlspecialchars($_SESSION["nombre"] ?? "Usuario"); ?>
                    </span>
                </div>

                <span class="navbar-session-divider" aria-hidden="true"></span>

                <a
                    href="<?php echo $baseUrl; ?>/logout.php"
                    class="navbar-logout"
                >
                    <i class="bi bi-box-arrow-right"></i>
                    Cerrar sesión
                </a>

            </div>

        </div>

    </div>

</nav>

<script>
(() => {
    const botonNavbar = document.querySelector("[data-navbar-toggle]");
    const contenidoNavbar = document.getElementById("navegacionPrincipal");

    if (!botonNavbar || !contenidoNavbar) {
        return;
    }

    botonNavbar.addEventListener("click", () => {
        const estaAbierta = contenidoNavbar.classList.toggle(
            "navbar-collapse-open"
        );

        botonNavbar.setAttribute("aria-expanded", String(estaAbierta));
    });
})();
</script>
