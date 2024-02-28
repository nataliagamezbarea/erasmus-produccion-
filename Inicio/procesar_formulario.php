<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $date = $_POST["date"];
    $message = $_POST["message"];

    // Conectar a la base de datos (ajusta estos valores según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "erasmus";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Preparar la declaración SQL para insertar datos en la tabla 'tu_tabla'
    $sql = "INSERT INTO contacto (nombre, apellidos, email, fecha, mensaje) VALUES ('$fname', '$lname', '$email', '$date', '$message')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Datos insertados correctamente en la base de datos.";
    } else {
        echo "Error al insertar datos en la base de datos: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si alguien trata de acceder directamente al archivo PHP sin enviar el formulario, redirige o realiza otra acción adecuada.
    echo "Acceso no permitido";
}
?>
