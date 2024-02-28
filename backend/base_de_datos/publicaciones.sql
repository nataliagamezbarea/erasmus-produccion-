CREATE TABLE publicaciones (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre_usuario VARCHAR(255),
    Correo VARCHAR(255),
    Pais VARCHAR(255),
    Categoria VARCHAR(255),
    Titulo VARCHAR(255),
    Ubicacion_Imagen VARCHAR(255),
    Descripcion TEXT,
    Num_likes INT DEFAULT 0,
    Fecha_publicacion DATE,
    Hora_publicacion TIME
);
