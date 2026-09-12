-- ============================================================
-- BASE DE DATOS: inventario
-- Sistema de Inventario - PHP + MySQL
--
-- Este archivo contiene la estructura de la base de datos.
-- No incluye datos reales de usuarios, productos o ventas.
-- Incluye únicamente una cuenta administradora demo
-- para pruebas locales del sistema.
-- ============================================================

CREATE DATABASE IF NOT EXISTS inventario
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE inventario;

-- ============================================================
-- TABLA: usuarios
-- ============================================================

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'vendedor') NOT NULL DEFAULT 'vendedor',
    estado TINYINT(1) NOT NULL DEFAULT 1,

    login_intentos_fallidos TINYINT UNSIGNED NOT NULL DEFAULT 0,
    login_bloqueado_hasta DATETIME DEFAULT NULL,

    token_recuperacion CHAR(64) DEFAULT NULL,
    token_recuperacion_expira DATETIME DEFAULT NULL,

    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- USUARIO ADMINISTRADOR DE DEMOSTRACIÓN
-- Contraseña: AdminDemo123!
-- Credenciales públicas para instalación local de demostración.
-- ============================================================

INSERT INTO usuarios (
    nombre,
    usuario,
    email,
    password,
    rol,
    estado,
    login_intentos_fallidos,
    login_bloqueado_hasta,
    token_recuperacion,
    token_recuperacion_expira
) VALUES (
    'Administrador Demo',
    'admin_demo',
    'admin@demo.local',
    '$2y$10$phBP8Atd4/eWXb6m9z6DYeXmakq.0KVwZw7mtN2uuI4SKEh7wcbsO',
    'admin',
    1,
    0,
    NULL,
    NULL,
    NULL
);

-- ============================================================
-- TABLA: categorias
-- ============================================================

CREATE TABLE IF NOT EXISTS categorias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- TABLA: productos
-- ============================================================

CREATE TABLE IF NOT EXISTS productos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    categoria_id INT UNSIGNED NOT NULL,
    precio_compra DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 5,
    imagen VARCHAR(255) DEFAULT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_productos_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB;

-- ============================================================
-- TABLA: ventas
-- ============================================================

CREATE TABLE IF NOT EXISTS ventas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    estado ENUM('realizada', 'anulada') NOT NULL DEFAULT 'realizada',

    CONSTRAINT fk_ventas_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB;

-- ============================================================
-- TABLA: detalle_ventas
-- ============================================================

CREATE TABLE IF NOT EXISTS detalle_ventas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    venta_id INT UNSIGNED NOT NULL,
    producto_id INT UNSIGNED NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_detalle_venta
        FOREIGN KEY (venta_id)
        REFERENCES ventas(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_detalle_producto
        FOREIGN KEY (producto_id)
        REFERENCES productos(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB;

-- ============================================================
-- FIN
-- ============================================================
