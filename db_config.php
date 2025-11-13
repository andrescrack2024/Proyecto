<?php
// Activar reporte de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar la sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Configuración de la Base de Datos
define('DB_HOST', 'sql312.infinityfree.com');
define('DB_NAME', 'if0_40403406_smarqueee_db');
define('DB_USER', 'if0_40403406');
define('DB_PASS', 'SXM4EmzAQM'); // Dejar vacío si usas XAMPP por defecto

// Opciones de PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>