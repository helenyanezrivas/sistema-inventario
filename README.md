# Sistema de Inventario

Aplicación web de gestión de inventario desarrollada como proyecto de portafolio. Permite administrar productos, categorías, usuarios y ventas desde una interfaz PHP conectada a MySQL.

## Resumen técnico

- Gestión de productos, categorías, usuarios y ventas con control de roles.
- Registro y anulación de ventas mediante transacciones para mantener consistente el stock.
- Dashboard con indicadores, productos de bajo stock y gráficos de ventas.
- Exportación de productos y ventas a Excel y PDF.
- Autenticación, recuperación de contraseña por SMTP y control de intentos de inicio de sesión.
- Medidas de seguridad aplicadas a sesiones, formularios, consultas y exportaciones.

## Tecnologías utilizadas

- PHP 8.2
- MySQL con InnoDB
- HTML5, CSS3 y JavaScript
- Bootstrap 5 y Bootstrap Icons
- Chart.js
- Composer
- PhpSpreadsheet
- Dompdf
- PHPMailer

## Funcionalidades principales

### Productos y categorías

- Crear, editar, listar y eliminar productos y categorías.
- Generación automática de códigos de producto.
- Control de stock y visualización de productos con stock bajo.
- Filtros por búsqueda, estado y stock.
- Exportación de productos a Excel y PDF.

### Usuarios y acceso

- Roles de administrador y vendedor.
- Creación, edición, activación y desactivación de usuarios desde el rol administrador.
- Inicio de sesión, cierre de sesión, recuperación y restablecimiento de contraseña.
- Límite de intentos fallidos de inicio de sesión por cuenta.

### Ventas y reportes

- Registro de ventas con validación de disponibilidad de stock.
- Descuento automático de stock al registrar una venta.
- Consulta de detalle, filtros y exportación de ventas a Excel y PDF.
- Anulación de ventas con restauración del stock e historial conservado.

### Dashboard

- Resumen de productos, categorías, ventas y ventas del día.
- Productos con stock bajo y últimas ventas.
- Gráficos de ventas de los últimos siete días y por categoría del mes actual.

## Seguridad implementada

- Contraseñas almacenadas con `password_hash()` y verificadas con `password_verify()`.
- Consultas preparadas para operaciones con parámetros.
- Protección CSRF en formularios y acciones sensibles.
- Regeneración del ID de sesión al iniciar sesión.
- Cookies de sesión con `HttpOnly`, `SameSite=Lax`, modo estricto y `Secure` al usar HTTPS.
- Validación de que el usuario de la sesión continúe activo y conserve su rol en MySQL.
- Límite de intentos de inicio de sesión almacenado en MySQL.
- Errores técnicos registrados mediante `error_log()` sin exponer detalles al usuario.
- Protección contra XSS en datos del gráfico y contra inyección de fórmulas en exportaciones Excel.

## Estructura del proyecto

```text
inventario/
├── assets/
│   └── css/
├── config/
│   ├── database.php
│   └── correo.example.php
├── includes/
│   ├── error_handler.php
│   ├── navbar.php
│   ├── security.php
│   └── session.php
├── views/
│   ├── categorias/
│   ├── productos/
│   ├── usuarios/
│   └── ventas/
├── composer.json
├── composer.lock
├── inventario.sql
├── index.php
├── login.php
├── recuperar.php
├── restablecer.php
└── logout.php
```

## Instalación rápida con XAMPP

### Requisitos

- XAMPP con Apache, MySQL y PHP 8.2.
- Composer.
- Extensiones PHP: `mysqli`, `mbstring`, `dom`, `gd`, `zip`, `xml` y `openssl`.

### 1. Clonar o copiar el proyecto

```bash
git clone https://github.com/helenyanezrivas/sistema-inventario.git
```

Ubica el proyecto en `C:\xampp\htdocs\inventario`.

### 2. Instalar dependencias

Desde la carpeta del proyecto ejecuta:

```bash
composer install
```

### 3. Importar la base de datos

1. Inicia Apache y MySQL desde XAMPP.
2. Crea una base de datos llamada `inventario` en phpMyAdmin.
3. Importa el archivo `inventario.sql` en esa base de datos.
4. Revisa los datos de conexión en `config/database.php` si tu entorno local usa valores distintos.

### 4. Configurar correo para recuperación de contraseña

Copia la plantilla pública:

```powershell
Copy-Item config\correo.example.php config\correo.php
```

Edita `config/correo.php` con el host, puerto, usuario, contraseña y correo remitente de tu proveedor SMTP. Este archivo contiene credenciales locales y está excluido de Git.

### 5. Acceder al sistema

Abre:

```text
http://localhost/inventario/
```

## Cuenta demo

| Campo | Valor |
|---|---|
| Correo | `admin@demo.local` |
| Contraseña | `AdminDemo123!` |

Estas credenciales son ficticias, públicas y están destinadas exclusivamente a una demostración local. El archivo `inventario.sql` no contiene usuarios reales, productos ni ventas reales; incluye únicamente esta cuenta administradora demo. Desde ella puedes crear usuarios vendedores o administradores.

## Sobre el proyecto

Este sistema fue desarrollado como proyecto personal para aplicar conocimientos de desarrollo web, bases de datos, seguridad, gestión de inventario y generación de reportes.

## Decisiones técnicas

- PHP procedural organizado por módulos y vistas.
- MySQL con tablas InnoDB, claves foráneas y restricciones de integridad.
- Transacciones para registrar ventas y anularlas sin desincronizar el stock.
- Control de acceso basado en roles y validación centralizada de sesiones activas.


## Autor

**Helen Yáñez Rivas**
Ingeniería en Ejecución en Computación e Informática
GitHub: [helenyanezrivas](https://github.com/helenyanezrivas)
