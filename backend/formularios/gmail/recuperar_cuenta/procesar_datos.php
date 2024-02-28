<?php
// Archivo: procesar_datos.php

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "erasmus";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Obtener datos del formulario
$codigo_verificacion = isset($_POST['codigo_verificacion']) ? $_POST['codigo_verificacion'] : '';
$gmail = isset($_POST['gmail']) ? $_POST['gmail'] : '';
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';

// Inicializar variables de mensajes
$mostrarAlerta = false;
$mensajeAlerta = '';
$tipoAlerta = '';
$redirectUrl = '';

// Inicializar $update_stmt
$update_stmt = null;

// Validar los datos del formulario
if (empty($codigo_verificacion) || empty($gmail) || empty($new_password)) {
    $mostrarAlerta = true;
    $mensajeAlerta = "Por favor, complete todos los campos del formulario.";
    $tipoAlerta = "error";
    $redirectUrl = "../../obtener_codigo.html";
} else {
    // Verificar el código de verificación y el correo electrónico utilizando consultas preparadas
    $sql = "SELECT * FROM usuarios_registrados WHERE codigo_verificacion = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $codigo_verificacion, $gmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Actualizar la contraseña utilizando consultas preparadas
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE usuarios_registrados SET password = ? WHERE codigo_verificacion = ? AND email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sss", $hashed_password, $codigo_verificacion, $gmail);

        if ($update_stmt->execute()) {
            $mostrarAlerta = true;
            $mensajeAlerta = "Contraseña actualizada correctamente.";
            $tipoAlerta = "success";
            $redirectUrl = "http://www.google.com"; // Cambiar a la URL deseada para éxito
        } else {
            $mostrarAlerta = true;
            $mensajeAlerta = "Error al actualizar la contraseña: " . $update_stmt->error;
            $tipoAlerta = "error";
            $redirectUrl = "../../obtener_codigo.html";
        }
    } else {
        $mostrarAlerta = true;
        $mensajeAlerta = "Código de verificación o correo electrónico incorrectos.";
        $tipoAlerta = "error";
        $redirectUrl = "../../obtener_codigo.html";
    }
}

// Cerrar la conexión
$stmt->close();
if ($update_stmt) {
    $update_stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Página con SweetAlert2</title>

    <!-- Incluye SweetAlert2 desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilo para los mensajes de SweetAlert2 -->
    <style>
        .swal2-popup {
            font-size: 1.6rem;
        }
    </style>
</head>
<body>

<?php
// Muestra una alerta si es necesario
if ($mostrarAlerta) {
    echo "<script>
            Swal.fire({
                title: '¡Hola!',
                text: '$mensajeAlerta',
                icon: '$tipoAlerta',
                confirmButtonText: 'OK',
                showCancelButton: false,
                showCloseButton: false,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '$redirectUrl';
                }
            });
         </script>";
}
?>

</body>
</html>
