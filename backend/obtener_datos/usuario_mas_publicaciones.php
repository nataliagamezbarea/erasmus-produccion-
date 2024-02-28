<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');  // Indicamos que la respuesta será en formato JSON

try {
    $pdo = new PDO('mysql:host=localhost;dbname=erasmus', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT Nombre_usuario, COUNT(*) AS NumeroDePublicaciones
            FROM publicaciones
            GROUP BY Nombre_usuario
            ORDER BY NumeroDePublicaciones DESC
            LIMIT 1";

    $stmt = $pdo->query($sql);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $nombreUsuarioMasPublicaciones = $result['Nombre_usuario'];
        $numeroDePublicaciones = $result['NumeroDePublicaciones'];

        echo json_encode(['nombre_usuario' => $nombreUsuarioMasPublicaciones, 'numero_de_publicaciones' => $numeroDePublicaciones]);
    } else {
        echo json_encode(['error' => 'No hay datos disponibles.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>