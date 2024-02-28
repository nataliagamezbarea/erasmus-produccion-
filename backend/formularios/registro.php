<?php
$mostrarAlerta = false; // Inicializa la variable
$redirectUrl = ''; // Variable para almacenar la URL de redirección

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario de registro
    $user = $_POST["user"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Conectar a la base de datos (reemplaza con tus propias credenciales)
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "erasmus";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Verificar si el correo electrónico ya está registrado
    $check_email_query = "SELECT * FROM usuarios_registrados WHERE email = ? OR nombre_usuario = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("ss", $email, $user);
    $stmt->execute();
    $check_email_result = $stmt->get_result();

    if ($check_email_result->num_rows > 0) {
        $row = $check_email_result->fetch_assoc();

        if ($row["email"] == $email && $row["nombre_usuario"] == $user) {
            // El correo y el usuario ya están registrados
            mostrarAlerta("Ya existe una cuenta registrada con este correo y nombre de usuario. Por favor, inicia sesión.", "error", "registro.html");
        } elseif ($row["email"] == $email) {
            // El correo ya está registrado
            mostrarAlerta("El correo electrónico ya está registrado. Por favor, utiliza otro correo.", "error", "registro.html");
        } elseif ($row["nombre_usuario"] == $user) {
            // El usuario ya está registrado
            mostrarAlerta("El nombre de usuario ya está en uso. Por favor, elige otro nombre de usuario.", "error", "registro.html");
        }
    } else {
        // El correo y el usuario no están registrados, procede con la inserción
        // Hashear la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Establecer la categoría como "Usuario Estándar"
        $categoria = "Usuario Estándar";

        // Inserción de datos en la base de datos
        $insert_query = "INSERT INTO usuarios_registrados (nombre_usuario, email, password, categoria) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $user, $email, $hashed_password, $categoria);

        if ($stmt->execute()) {
            // Registro exitoso
            mostrarAlerta("¡Registro exitoso!", "success", "Inicio_sesion.html");
        } else {
            // Error en la inserción
            error_log("Error al registrar el usuario: " . $stmt->error);
            mostrarAlerta("Error al registrar el usuario. Por favor, intenta nuevamente.", "error", "registro.html");
        }
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Si alguien intenta acceder directamente al archivo PHP, puedes redirigir o mostrar un mensaje de error
    mostrarAlerta("Acceso no autorizado", "error", "registro.html");
}

function mostrarAlerta($mensaje, $tipo, $redirect) {
    global $mostrarAlerta, $mensajeAlerta, $tipoAlerta, $redirectUrl;
    $mostrarAlerta = true;
    $mensajeAlerta = $mensaje;
    $tipoAlerta = $tipo;
    $redirectUrl = $redirect;
}
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
