<?php
// Lee el contenido del archivo credenciales.json
$credenciales_json = file_get_contents('credenciales.json');
$credenciales_data = json_decode($credenciales_json, true);

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "erasmus";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Asegúrate de que la categoría sea diferente de "Usuario estándar" antes de procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && $credenciales_data['categoria'] !== 'Usuario estándar') {
    // Obtener datos del formulario
    $titulo = $_POST["titulo"];
    $ubicacion_imagen = $_FILES["ubicacion_imagen"]["name"];
    $descripcion = $_POST["descripcion"];

    // Carpeta de destino
    $imagenes_erasmus = "imagenes_erasmus/";

    // Verificar si la carpeta de destino existe, si no, crearla
    if (!file_exists($imagenes_erasmus)) {
        mkdir($imagenes_erasmus, 0777, true);
    }

    // Ruta completa de destino del archivo
    $ruta_destino = $imagenes_erasmus . basename($ubicacion_imagen);

    // Mover el archivo cargado a la ubicación deseada
    if (move_uploaded_file($_FILES["ubicacion_imagen"]["tmp_name"], $ruta_destino)) {
        // Datos del archivo credenciales.json
        $nombre_usuario = $credenciales_data['nombre_usuario'];
        $email = $credenciales_data['email'];
        $categoria = $credenciales_data['categoria'];
        $pais = $credenciales_data['pais'];

        // Fecha y hora actuales
        $fecha_publicacion = date("Y-m-d");
        $hora_publicacion = date("H:i:s");

        // Inserta datos en la tabla publicaciones
        $sql = "INSERT INTO publicaciones (Titulo, Ubicacion_Imagen, Descripcion, Nombre_usuario, Correo, Pais, Categoria, Fecha_publicacion, Hora_publicacion) 
                VALUES ('$titulo', '$ruta_destino', '$descripcion', '$nombre_usuario', '$email', '$pais', '$categoria', '$fecha_publicacion', '$hora_publicacion')";

        // Verifica la categoría antes de permitir la publicación
        if ($categoria !== 'Estandar') {
            // Publica la publicación
            if ($conn->query($sql) === TRUE) {
                echo json_encode(array("mensaje" => "Publicación creada exitosamente"));
            } else {
                echo json_encode(array("error" => "Error al insertar datos: " . $conn->error));
            }
        } else {
            echo json_encode(array("error" => "No puedes publicar como Usuario estándar"));
        }
    } else {
        echo json_encode(array("error" => "Error al mover el archivo a la carpeta de destino"));
    }
} else {
    echo json_encode(array("error" => "No tienes permisos para realizar esta acción"));
}

// Cierra la conexión
$conn->close();
?>
