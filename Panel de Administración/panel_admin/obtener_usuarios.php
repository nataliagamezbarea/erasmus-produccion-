<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuarios_registrados";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuarios = array();

    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
} else {
    echo "0 resultados";
}

$conn->close();
?>
