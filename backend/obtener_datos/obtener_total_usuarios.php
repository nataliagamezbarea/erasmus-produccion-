<?php

// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Establecer encabezados CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Consulta SQL para obtener el número total de cuentas
$sql = "SELECT COUNT(*) as total_cuentas FROM usuarios_registrados";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si la consulta se ejecutó correctamente
if ($result) {
    // Obtener el resultado como un array asociativo
    $row = $result->fetch_assoc();

    // Crear un array con la respuesta
    $response = array('total_cuentas' => $row['total_cuentas']);

    // Imprimir la respuesta como JSON
    echo json_encode($response);
} else {
    // Imprimir un error en formato JSON
    echo json_encode(array('error' => 'Error en la consulta: ' . $conn->error));
}

// Cerrar la conexión
$conn->close();

?>
