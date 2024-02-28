<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos GET y POST
header("Access-Control-Allow-Methods: GET, POST");

// Permitir el contenido con credenciales (cookies)
header("Access-Control-Allow-Credentials: true");

// Permitir ciertos encabezados
header("Access-Control-Allow-Headers: Content-Type");

// Establecer el tipo de contenido para la respuesta como JSON
header("Content-Type: application/json");

// Establecer la conexión con la base de datos (ajusta estos valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos de la tabla publicaciones
$sql = "SELECT Id, Nombre_usuario, Correo, Pais, Categoria, Titulo, Ubicacion_Imagen, Descripcion, Num_likes, Fecha_publicacion, Hora_publicacion FROM publicaciones";
$result = $conn->query($sql);

// Verificar si hay errores en la consulta
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Mostrar los datos en formato JSON
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Escapar los datos para prevenir inyección SQL
        $row = array_map('htmlspecialchars', $row);

        // Asegúrate de que la ruta de la imagen sea una URL completa
        $imagePath = $row['Ubicacion_Imagen'];

        // Decodificar el porcentaje y el número que representa la barra
        $imagePath = urldecode($imagePath);

        // Corregir barras dobles en la URL
        $imagePath = str_replace('//', '/', $imagePath);

        // Verificar si la ruta ya contiene '/imagenes_erasmus', si no, agregarla
        if (strpos($imagePath, '/imagenes_erasmus') === false) {
            $imagePath = 'http://localhost/erasmus/backend/formularios/' . $imagePath;
        }

        $row['Ubicacion_Imagen'] = $imagePath;

        // Agregar el row al array de datos
        $data[] = $row;
    }
}

// Cerrar la conexión
$conn->close();

// Enviar los datos como JSON
echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
