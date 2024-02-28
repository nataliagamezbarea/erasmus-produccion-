<?php
// Permitir solicitudes desde cualquier origen (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Verificar si la solicitud es una opción preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    // Tu conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "erasmus");

    // Verificar si la conexión fue exitosa
    if ($conn->connect_error) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Error de conexión a la base de datos']);
        exit;
    }

    // Consulta SQL para contar los registros en la tabla de usuarios registrados
    $sql = "SELECT COUNT(*) as total FROM publicaciones";
    $result = $conn->query($sql);

    // Verificar si la consulta fue exitosa
    if ($result) {
        // Obtener el resultado como un array asociativo
        $row = $result->fetch_assoc();

        // Convertir el total a un número entero
        $total = intval($row['total']);

        // Devolver el resultado en formato JSON
        header('Content-Type: application/json');
        echo json_encode(['total' => $total]);
    } else {
        // Si hay un error en la consulta, devolver un mensaje de error en formato JSON
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Error al ejecutar la consulta']);
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error en la consulta SQL: ' . $e->getMessage()]);
} finally {
    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
