<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Conexión a la base de datos (ajusta estos valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Seleccionar la base de datos
if (!$conn->select_db($dbname)) {
    die("Error al seleccionar la base de datos: " . $conn->error);
}

// Cambiar el idioma a español
$conn->query("SET lc_time_names = 'es_ES'");

// Consulta para obtener el número de publicaciones para cada día de la semana en español
$query = "SELECT 
            DAYOFWEEK(Fecha_publicacion) AS DiaSemanaID,
            DATE_FORMAT(Fecha_publicacion, '%W') AS DiaSemana,
            COUNT(*) AS NumPublicaciones
          FROM publicaciones
          GROUP BY DiaSemanaID
          ORDER BY DiaSemanaID";

$result = $conn->query($query);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'No hay resultados'));
}

// Cerrar la conexión
$conn->close();
?>
