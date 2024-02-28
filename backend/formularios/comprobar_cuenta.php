<?php
$mostrarAlerta = false; // Inicializa la variable
$redirectUrl = ''; // Variable para almacenar la URL de redirección

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario de Inicio de sesión
    $email_usuario = $_POST["email"];
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

    // Consulta para obtener el hash de la contraseña del usuario
    $sql = "SELECT nombre_usuario, email, password, categoria FROM usuarios_registrados WHERE email = ? OR nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email_usuario, $email_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

        // Verificar el nombre de usuario, el correo electrónico y la contraseña
        if ((isset($row["nombre_usuario"]) || isset($row["email"])) && password_verify($password, $hashed_password)) {
            // Inicio de sesión exitoso
            $mostrarAlerta = true;
            $mensajeAlerta = "Inicio de sesión exitoso";
            $tipoAlerta = "success";

            // Establecer cookies persistentes para recordar el nombre de usuario y el estado de Inicio de sesión
            setcookie('nombre_usuario', $row["nombre_usuario"], time() + (86400 * 30), "/"); // Cookie válida por 30 días
            setcookie('sesion_iniciada', true, time() + (86400 * 30), "/"); // Cookie válida por 30 días

            // Guardar credenciales en un archivo JSON
            $credenciales = [
                'nombre_usuario' => $row["nombre_usuario"],
                'email' => $row["email"],
                'categoria' => $row["categoria"],
            ];

            file_put_contents('../../credenciales/credenciales.json', json_encode($credenciales));

            // Verificar si la categoría es "Administrador"
            if ($row["categoria"] === "Administrador") {
                $redirectUrl = 'http://127.0.0.1:5500/Panel%20de%20Administraci%C3%B3n/panel_admin/Inicio/panel_admin.html'; // Redirección solo para administradores
            } else {
                $redirectUrl = 'http://127.0.0.1:5500/blog/index.html'; // Redirección para usuarios normales
            }
        } else {
            // Credenciales incorrectas
            $mostrarAlerta = true;
            $mensajeAlerta = "Credenciales incorrectas";
            $tipoAlerta = "error";
            $redirectUrl = 'registro.html'; // Redirección en caso de credenciales incorrectas
        }
    } else {
        // Usuario no encontrado
        $mostrarAlerta = true;
        $mensajeAlerta = "Usuario no encontrado";
        $tipoAlerta = "error";
        $redirectUrl = 'registro.html'; // Redirección en caso de usuario no encontrado
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Si alguien intenta acceder directamente al archivo PHP, puedes redirigir o mostrar un mensaje de error
    $mostrarAlerta = true;
    $mensajeAlerta = "Acceso no autorizado";
    $tipoAlerta = "error";
    $redirectUrl = 'registro.html'; // Redirección en caso de acceso no autorizado
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
