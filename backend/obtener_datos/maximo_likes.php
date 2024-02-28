<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');  // Indicamos que la respuesta será en formato JSON

try {
    $pdo = new PDO('mysql:host=localhost;dbname=erasmus', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT Nombre_usuario, MAX(Num_likes) AS MaxLikes
            FROM publicaciones
            GROUP BY Nombre_usuario
            ORDER BY MaxLikes DESC
            LIMIT 1";

    $stmt = $pdo->query($sql);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $nombreUsuarioConMaxLikes = $result['Nombre_usuario'];
        $maxLikes = $result['MaxLikes'];

        echo json_encode(['nombre_usuario' => $nombreUsuarioConMaxLikes, 'max_likes' => $maxLikes]);
    } else {
        echo json_encode(['error' => 'No hay datos disponibles.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
}
?>
