<?php
// Conexión a la base de datos (ajusta los valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del usuario desde el archivo JSON
$credenciales = json_decode(file_get_contents('/credenciales/credenciales.json'), true);

// Datos del comentario
$commentText = $_POST['comment-textarea'];
$commentUser = $credenciales['nombre_usuario'];

// Preparar la consulta para insertar el comentario
$sql = "INSERT INTO Comentarios (UserName, CommentText) VALUES ('$commentUser', '$commentText')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    // Éxito al insertar el comentario
    echo json_encode(array('success' => true));
} else {
    // Error al insertar el comentario
    echo json_encode(array('success' => false, 'error' => $conn->error));
}

// Cerrar la conexión
$conn->close();
?>
