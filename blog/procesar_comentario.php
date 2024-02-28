<?php

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

// Construir la ruta completa al archivo credenciales.json
$credencialesPath = __DIR__ . '/credenciales.json';

// Verificar si el archivo existe
if (file_exists($credencialesPath)) {

    // Leer el archivo credenciales.json
    $credenciales = json_decode(file_get_contents($credencialesPath), true);

    // Obtener el nombre de usuario del archivo JSON
    $username = $credenciales['nombre_usuario'];

    // Array de países
    $paises = array(
        'Dinamarca', 'Finlandia', 'Francia', 'Irlanda', 'Portugal', 'Italia', 'Malta', 'República Checa', 'Polonia', 'Estonia'
    );

    // Array de publicaciones ficticias por país
    $publicaciones_por_pais = array(
        'Dinamarca' => array(
            'Explorando la encantadora Copenhague',
            'Sabores daneses: Un viaje culinario por Dinamarca'
        ),
        'Finlandia' => array(
            'Descubriendo la magia de la aurora boreal en Finlandia',
            'Entre saunas y lagos: La experiencia finlandesa única'
        ),
        // Agrega publicaciones ficticias para otros países según sea necesario
    );

    // Iterar sobre los países y sus publicaciones
    foreach ($paises as $pais) {
        foreach ($publicaciones_por_pais[$pais] as $commentText) {

            // Insertar comentario en la base de datos
            $sql = "INSERT INTO Comentarios (UserName, CommentText) VALUES ('$username', '$commentText - $pais')";

            if ($conn->query($sql) === TRUE) {
                echo "Comentario enviado con éxito: $commentText - $pais<br>";
            } else {
                echo "Error al enviar el comentario: " . $conn->error . "<br>";
            }
        }
    }

} else {
    echo "Error: No se pudo encontrar el archivo de credenciales";
}

// Cerrar la conexión
$conn->close();

?>
