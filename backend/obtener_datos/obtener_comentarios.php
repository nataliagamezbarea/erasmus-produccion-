<?php
// Conexión a la base de datos (ajusta los valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener comentarios
$sql = "SELECT * FROM Comentarios";
$result = $conn->query($sql);

// Obtener resultados como un array asociativo
$comentarios = array();
while ($row = $result->fetch_assoc()) {
    $comentarios[] = $row;
}

// Convertir el array a formato JSON y enviarlo
echo json_encode($comentarios);

// Cerrar la conexión
$conn->close();
?>
