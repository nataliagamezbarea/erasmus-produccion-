<?php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$base_datos = 'erasmus';

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT País, SUM(Num_likes) AS TotalLikes 
        FROM publicaciones 
        GROUP BY País 
        ORDER BY TotalLikes DESC 
        LIMIT 5";

$resultado = $conexion->query($sql);

if ($resultado) {
    $paises = $resultado->fetch_all(MYSQLI_ASSOC);

    echo "Los 5 países con más likes:<br>";
    
    for ($i = 0; $i < min(5, count($paises)); $i++) {
        echo "Pais " . ($i + 1) . ": " . $paises[$i]['País'] . " - " . $paises[$i]['TotalLikes'] . " likes<br>";
    }

    $resultado->free();
} else {
    echo "Error en la consulta: " . $conexion->error;
}

$conexion->close();
?>
