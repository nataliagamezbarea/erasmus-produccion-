<?php

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conectar a la base de datos (reemplaza con tus propias credenciales)
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "erasmus";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Recuperar datos del formulario
    $commentText = $_POST['comment-textarea'];

    // Construir la ruta completa al archivo credenciales.json
    $credencialesPath = __DIR__ . 'credenciales.json';

    // Verificar si el archivo existe
    if (file_exists($credencialesPath)) {

        // Leer el archivo credenciales.json
        $credenciales = json_decode(file_get_contents($credencialesPath), true);

        // Obtener el nombre de usuario del archivo JSON
        $username = $credenciales['nombre_usuario'];

        // Insertar comentario en la base de datos
        $sql = "INSERT INTO Comentarios (UserName, CommentText) VALUES ('$username', '$commentText')";

        if ($conn->query($sql) === TRUE) {
            echo "Comentario enviado con éxito";
        } else {
            echo "Error al enviar el comentario: " . $conn->error;
        }

    } else {
        echo "Error: No se pudo encontrar el archivo de credenciales";
    }

    // Cerrar la conexión
    $conn->close();
}
?>
