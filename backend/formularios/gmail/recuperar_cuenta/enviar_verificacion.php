<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../Exception.php';
require '../PHPMailer.php';
require '../SMTP.php';

function generarCodigoAleatorio($longitud = 18) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=[]{}|;:,.<>?';
    return substr(str_shuffle($caracteres), 0, $longitud);
}

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'ngamezb2006@gmail.com';
$mail->Password = 'cuatytvsxhvgvagr'; // Reemplaza 'tu_contraseña' con tu contraseña real de Gmail
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mostrarAlerta = false;
$mensajeAlerta = '';
$tipoAlerta = '';
$redirectUrl = '';

try {
    $gmail = isset($_POST['gmail']) ? $_POST['gmail'] : '';

    if (empty($gmail)) {
        throw new Exception('El campo de correo electrónico está vacío.');
    }

    $conn = new mysqli("localhost", "root", "", "erasmus");

    if ($conn->connect_error) {
        throw new Exception("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    $query = $conn->prepare("SELECT * FROM usuarios_registrados WHERE email = ?");
    $query->bind_param("s", $gmail);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = $row['nombre_usuario'];
        $codigo_verificacion = generarCodigoAleatorio();

        $updateQuery = $conn->prepare("UPDATE usuarios_registrados SET codigo_verificacion = ? WHERE email = ?");
        $updateQuery->bind_param("ss", $codigo_verificacion, $gmail);
        $updateQuery->execute();

        $mail->setFrom('ngamezb2006@gmail.com', "Web");
        $mail->addAddress($gmail, $nombre_usuario);
        $mail->isHTML(true);
        $mail->Subject = "Recuperación de cuenta - Código de Verificación";
        $mail->CharSet = 'UTF-8';

        $mensaje = "Hola $nombre_usuario, <br><br>";
        $mensaje .= "Tu nuevo código de verificación es: $codigo_verificacion <br><br>";
        $mensaje .= "Este código es necesario para completar el proceso de recuperación de cuenta. Gracias.";

        $mail->Body = $mensaje;

        $mail->send();
        $mostrarAlerta = true;
        $mensajeAlerta = '¡El mensaje ha sido enviado correctamente!';
        $tipoAlerta = 'success';
        $redirectUrl = 'https://www.google.com'; // URL para éxito
    } else {
        $mostrarAlerta = true;
        $mensajeAlerta = 'No se encontró ningún usuario con el correo electrónico proporcionado.';
        $tipoAlerta = 'error';
        $redirectUrl = '../../obtener_codigo.html'; // URL para error
    }

    $conn->close();
} catch (Exception $e) {
    error_log($e->getMessage(), 0);
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
                    document.body.style.overflow = 'auto'; // Restaura el desbordamiento al cuerpo
                    window.location.href = '$redirectUrl';
                }
            });

            document.body.style.overflow = 'hidden'; // Oculta el desbordamiento al cuerpo
         </script>";
}
?>

</body>
</html>
