<?php
header('Content-Type: application/json; charset=utf-8');

// Verificar si llegó un archivo
if (!isset($_FILES['archivo'])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibió ningún archivo."
    ]);
    exit;
}

// Datos del archivo recibido
$nombre = $_FILES['archivo']['name'];
$tamano = $_FILES['archivo']['size'];
$tipo   = $_FILES['archivo']['type'];

echo json_encode([
    "ok" => true,
    "mensaje" => "Archivo recibido correctamente.",
    "archivo" => [
        "nombre" => $nombre,
        "tamano" => $tamano,
        "tipo"   => $tipo
    ]
]);