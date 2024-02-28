<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$ruta_credenciales = __DIR__ . '/credenciales/credenciales.json';

try {
    $contenido = file_get_contents($ruta_credenciales);

    if ($contenido === false) {
        http_response_code(500); // Internal Server Error
        echo json_encode(array('error' => 'Error al leer el archivo de credenciales.'));
    } else {
        echo $contenido;
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Error en el servidor.'));
}
?>
