<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos de solicitud que se utilizarán
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Permitir ciertos encabezados HTTP
header("Access-Control-Allow-Headers: Content-Type");

// Conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

// Inicializar la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    // Enviar un código de estado HTTP 500 (Error interno del servidor)
    http_response_code(500);
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los cinco países con más usuarios y sus porcentajes del total (excluyendo usuarios sin país definido)
$sql = "SELECT pais, COUNT(*) as total_usuarios, (COUNT(*) / (SELECT COUNT(*) FROM usuarios_registrados WHERE pais IS NOT NULL)) * 100 as porcentaje FROM usuarios_registrados WHERE pais IS NOT NULL GROUP BY pais HAVING total_usuarios > 0 ORDER BY total_usuarios DESC LIMIT 5";

// Ejecutar la consulta de manera segura utilizando una sentencia preparada
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();

    // Obtener el resultado como array asociativo
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resultado = $result->fetch_all(MYSQLI_ASSOC);

        // Enviar el resultado como JSON
        echo json_encode($resultado);
    } else {
        // Enviar un código de estado HTTP 404 (No encontrado)
        http_response_code(404);
        echo "No se encontraron resultados";
    }

    // Cerrar la sentencia preparada
    $stmt->close();
} else {
    // Enviar un código de estado HTTP 500 (Error interno del servidor) y el mensaje de error
    http_response_code(500);
    echo "Error en la preparación de la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
