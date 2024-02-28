CREATE TABLE IF NOT EXISTS usuarios_registrados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    pais VARCHAR(50) NOT NULL,
    categoria VARCHAR(50), -- Columna para el país (puede ser nula)
    codigo_verificacion VARCHAR(18) NOT NULL
);

