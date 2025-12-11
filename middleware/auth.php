<?php
// middleware/auth.php
// Autor: Miguel Ángel Lara Hermosillo
// Fecha: 12/08/2025
//  Funciones incluidas:
//  - Validación de sesión
//  - Validación de estado de usuario en BD
//  - Validación de roles por módulo
//  - Protección contra acceso no autorizado
//  - Soporte para AJAX (código 401 y 403)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Archivos requeridos

require_once __DIR__ . "/../../config.php";



//---------------------------------------------------------------------

// Regenerar ID de sesión para prevenir fijación de sesión
if (!isset($_SESSION["session_start_time"])) {
    $_SESSION["session_start_time"] = time();
} elseif (time() - $_SESSION["session_start_time"] > 300) {
    session_regenerate_id(true);
    $_SESSION["session_start_time"] = time();
}

// ============================================================
//Validar si la petición es AJAX o normal

// Detectar si la petición es AJAX
function isAjaxRequest()
{
    return isset($_SERVER["HTTP_X_REQUESTED_WITH"])
        && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";
}

function denyAccessAndExit($reason)
{
    $isAjax = isAjaxRequest();

    if ($reason === "rol_invalido") {
        $status = 403; // Forbidden (no tienes permisos)
    } else {
        $status = 401; // Unauthorized (sesión inválida)
    }

    if ($isAjax) {
        http_response_code($status);
        echo json_encode([
            "ok" => false,
            "reason" => $reason
        ]);
        exit;
    }

    // Petición normal
    header("Location: " . BASE_URL . "Vista/login.php?estado=" . $reason);
    exit;
}

// ============================================================
//  Validar sesión y estado de usuario
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

//---------------------------------------------------------------------
//Validacion de sesión

//  Usuario NO autenticado
if (!isset($_SESSION["idUsuario"]) || !isset($_SESSION["rol"])) {
    header("Location: " . BASE_URL . "Vista/login.php?estado=invalid");
    exit;
}
//---------------------------------------------------------------------

//  Validar estado del usuario cada ves que se recarga una página 
//cargar el controlador de usuario
require_once __DIR__ . "/../../Controlador/Intermediarios/UsuarioController/UsuarioController.php";

try {
    $usuarioCtrl = new UsuarioController();
    $idUsuario = $_SESSION["idUsuario"];

    // Validar estado real desde la base de datos
    $usuarioActivo = $usuarioCtrl->usuarioEstaActivo($idUsuario);

    if (!$usuarioActivo) {
        session_unset();
        session_destroy();
        denyAccessAndExit("user_inactivo");
    }

} catch (Exception $e) {
    error_log("Error en auth al validar estado de usuario: " . $e->getMessage());
    denyAccessAndExit("server_error");
}

//---------------------------------------------------------------------

// VALIDACIÓN DE ACCESO POR RUTA SEGÚN ROL
$ruta = strtolower($_SERVER["REQUEST_URI"]);
$rol = $_SESSION["rol"];

// Rutas restringidas por rol
$reglas = [
    "Administrador"   => "/vista/admin/",
    "JefeDeCarrera"   => "/vista/jefecarrera/",
    "Docente"         => "/vista/docente/"
];
// Si la vista pertenece a un rol diferente pues se le denega el acceso
foreach ($reglas as $nombreRol => $path) {
    if ($rol !== $nombreRol && strpos($ruta, $path) !== false) {
        header("Location: " . BASE_URL . "Vista/redirect.php");
        exit;
    }
}
//---------------------------------------------------------------------

/**
 * Función: requireRole
 * Valida que el usuario tenga uno de los roles permitidos.
 *
 * @param array $moduleKey  Clave del módulo para obtener los roles permitidos
 */
function requireRole(string $moduleKey)
{
    $roles = require __DIR__ . "/roles.php";

    if (!isset($roles[$moduleKey])) {
        http_response_code(500);
        exit("Rol no definido para '$moduleKey' en roles.php");
    }

    if (!isset($_SESSION["rol"])) {
        header("Location: " . BASE_URL . "Vista/login.php?estado=invalid");
        exit;
    }

    $rolUsuario = $_SESSION["rol"];
    $rolesPermitidos = $roles[$moduleKey];

    if (!in_array($rolUsuario, $rolesPermitidos)) {
        header("Location: " . BASE_URL . "Vista/redirect.php?estado=rol_invalido");
        exit;
    }
}
