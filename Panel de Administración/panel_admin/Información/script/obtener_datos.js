document.addEventListener("DOMContentLoaded", function () {
    // Cargar las credenciales desde el archivo JSON
    fetch('/credenciales/credenciales.json')
        .then(response => response.json())
        .then(credenciales => {
            const { nombre_usuario, email } = credenciales;

            // Utilizar el nombre de usuario y el correo electrónico como sea necesario
            console.log('Nombre de usuario:', nombre_usuario);
            console.log('Correo electrónico:', email);

            // Mostrar solo el nombre de usuario y el correo electrónico en el HTML
            document.getElementById("nombre_usuario").textContent = nombre_usuario;
            document.getElementById("email").textContent = email;

            // Realizar la solicitud HTTP para el número de publicaciones utilizando la API Fetch
            const apiUrlNumeroPublicaciones = "http://localhost/erasmus/backend/obtener_datos/numero_publicaciones.php";
            fetch(apiUrlNumeroPublicaciones)
                .then(response => response.json())
                .then(data => {
                    if (data && 'total' in data) {
                        const numeroPublicaciones = data.total;
                        document.getElementById("numero_publicaciones").textContent = numeroPublicaciones;
                    } else {
                        console.error("El formato de respuesta para el número de publicaciones no es el esperado.");
                    }
                })
                .catch(error => {
                    console.error(`Error al realizar la solicitud para el número de publicaciones: ${error}`);
                });

            // Realizar la solicitud HTTP para el número máximo de likes utilizando la API Fetch
            const apiUrlMaxLikes = "http://localhost/erasmus/backend/obtener_datos/maximo_likes.php";
            fetch(apiUrlMaxLikes)
                .then(response => response.json())
                .then(data => {
                    if (data && 'max_likes' in data) {
                        const maxLikes = data.max_likes;
                        document.getElementById("max_likes").textContent = maxLikes;
                    } else {
                        console.error("El formato de respuesta para el número máximo de likes no es el esperado.");
                    }
                })
                .catch(error => {
                    console.error(`Error al realizar la solicitud para el número máximo de likes: ${error}`);
                });

            // Realizar la solicitud HTTP para el usuario con más publicaciones utilizando la API Fetch
            const apiUrlUsuarioMasPublicaciones = "http://localhost/erasmus/backend/obtener_datos/usuario_mas_publicaciones.php";
            fetch(apiUrlUsuarioMasPublicaciones)
                .then(response => response.json())
                .then(data => {
                    if (data && 'nombre_usuario' in data) {
                        const usuarioMasPublicaciones = data.nombre_usuario;

                        // Display only the username
                        console.log('Usuario con más publicaciones:', usuarioMasPublicaciones);

                        // If you want to display it in HTML
                        document.getElementById("usuario_mas_publicaciones").textContent = usuarioMasPublicaciones;
                    } else {
                        console.error("El formato de respuesta para el usuario con más publicaciones no es el esperado.");
                    }
                })
                .catch(error => {
                    console.error(`Error al realizar la solicitud para el usuario con más publicaciones: ${error}`);
                });

            // Realizar la solicitud HTTP para el número de países utilizando la API Fetch
            const apiUrlNumeroPaises = "http://localhost/erasmus/backend/obtener_datos/numero_paises.php";
            fetch(apiUrlNumeroPaises)
                .then(response => response.json())
                .then(data => {
                    if (data && 'total_paises' in data) {
                        const numeroPaises = data.total_paises;
                        document.getElementById("numero_paises").textContent = numeroPaises;
                    } else {
                        console.error("El formato de respuesta para el número de países no es el esperado.");
                    }
                })
                .catch(error => {
                    console.error(`Error al realizar la solicitud para el número de países: ${error}`);
                });

        })
        .catch(error => {
            console.error(`Error al cargar las credenciales: ${error}`);
        });
});
