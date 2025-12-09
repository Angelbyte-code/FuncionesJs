<?php
// middleware/auth.php
// Autor: Miguel Ángel Lara Hermosillo
// Fecha: 12/08/2025


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Archivos requeridos
require_once __DIR__ . "/../../config.php";

// Regenerar ID de sesión para prevenir fijación de sesión
if (!isset($_SESSION["session_start_time"])) {
    $_SESSION["session_start_time"] = time();
} elseif (time() - $_SESSION["session_start_time"] > 300) { 
    session_regenerate_id(true);
    $_SESSION["session_start_time"] = time();
}

// Gestión de tiempo de inactividad (opcional)
/*$maxInactividad = 30; // 20 minutos

if (isset($_SESSION["ultimo_movimiento"])) {
    $inactivo = time() - $_SESSION["ultimo_movimiento"];

    if ($inactivo > $maxInactividad) {
        session_unset();
        session_destroy();
        header("Location: " . BASE_URL . "Vista/login.php?estado=session_expirada");
        exit;
    }
}

$_SESSION["ultimo_movimiento"] = time();
*/
// Obtener ruta actual solicitada
$currentPath = $_SERVER["REQUEST_URI"];

// Si intenta entrar al login pero ya tiene sesión válida
if (strpos($currentPath, "/Vista/login.php") !== false) {
    if (
        isset($_SESSION["idUsuario"]) &&
        isset($_SESSION["rol"]) &&
        isset($_SESSION["estado"]) &&
        $_SESSION["estado"] === "Activo"
    ) {
        header("Location: " . BASE_URL . "Vista/redirect.php");
        exit;
    }
}



//  Usuario NO autenticado
if (!isset($_SESSION["idUsuario"]) || !isset($_SESSION["rol"])) {
    header("Location: " . BASE_URL . "Vista/login.php?estado=no_autorizado");
    exit;
}


//  Usuario inactivo
if (isset($_SESSION["estado"]) && $_SESSION["estado"] !== "Activo") {
    session_destroy();
    header("Location: " . BASE_URL . "Vista/login.php?estado=user_inactivo");
    exit;
}


//  Validación de rol según la vista solicitada
$rol = $_SESSION["rol"];
$ruta = strtolower($_SERVER["REQUEST_URI"]);

// Rutas restringidas por rol
$reglas = [
    "Administrador"   => "/vista/admin/",
    "JefeDeCarrera"   => "/vista/jefecarrera/",
    "Docente"         => "/vista/docente/"
];

// Si la vista pertenece a un rol diferente pues se le denega el acceso

foreach ($reglas as $nombreRol => $path) {
    if ($rol !== $nombreRol && strpos($ruta, $path) !== false) {
        header("Location: " . BASE_URL . "Vista/login.php?estado=rol_invalido");
        exit;
    }
}

