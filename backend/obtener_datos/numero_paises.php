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

    // Consulta SQL para contar las publicaciones distintas y no vacías por país
    $sql = "SELECT Pais, COUNT(*) as total_publicaciones FROM publicaciones WHERE Pais IS NOT NULL AND Pais <> '' GROUP BY Pais";
    $result = $conn->query($sql);

    // Verificar si la consulta fue exitosa
    if ($result) {
        // Obtener el resultado como un array asociativo
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Obtener el total de países
        $total_paises = count($data);

        // Devolver el resultado en formato JSON con la misma estructura
        header('Content-Type: application/json');
        echo json_encode(['total_paises' => $total_paises]);
    } else {
        // Si hay un error en la consulta, devolver un mensaje de error en formato JSON con la misma estructura
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
