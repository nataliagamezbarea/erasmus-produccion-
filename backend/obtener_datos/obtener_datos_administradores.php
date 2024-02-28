<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erasmus";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

// Consulta SQL con sentencia preparada
$sql = "SELECT nombre_usuario, email, categoria, pais FROM usuarios_registrados WHERE categoria = ?";
$stmt = $conn->prepare($sql);
$category = 'administrador';
$stmt->bind_param("s", $category);
$stmt->execute();

// Verificar si hay resultados
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mostrar los datos de los administradores
    while($row = $result->fetch_assoc()) {
        echo "Nombre: " . $row["nombre_usuario"]. " - Email: " . $row["email"]. " - Categoría: " . $row["categoria"]. " - País: " . $row["pais"]. "<br>";
        // Añade más campos según sea necesario
    }
} else {
    echo "No se encontraron administradores.";
}

// Cerrar la conexión de manera segura
$stmt->close();
$conn->close();
?>
