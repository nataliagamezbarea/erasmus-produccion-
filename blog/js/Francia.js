// Hacer la petición AJAX
$.ajax({
    url: 'http://localhost/erasmus/backend/obtener_datos/obtener_publicaciones.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // Filtrar las publicaciones por la categoría "Francia"
        var publicacionesFrancia = data.filter(function(publicacion) {
            return publicacion.Pais === 'Francia';
        });

        // Manejar los datos filtrados
        if (publicacionesFrancia.length > 0) {
            // Iterar sobre cada publicación en los datos filtrados
            publicacionesFrancia.forEach(function(publicacion) {
                // Resto del código permanece igual
                var fechaPublicacion = new Date(publicacion.Fecha_publicacion);
                var formattedFecha = fechaPublicacion.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' });

                var publicacionHTML = `
                    <div class="col-md-4">
                        <div class="card">
                            <a href="post.html">
                                <img class="img-fluid img-thumb" src="${publicacion.Ubicacion_Imagen}" alt="">
                            </a>
                            <div class="card-block">
                                <h2 class="card-title"><a href="post.html">${publicacion.Titulo}</a></h2>
                                <div class="metafooter">
                                    <div class="wrapfooter">
                                        <h4 class="card-text descripcion-card">${publicacion.Descripcion}</h4>
                                        <span class="meta-footer-thumb">
                                            <a href="author.html"><img class="author-thumb" src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="${publicacion.Nombre_usuario}"></a>
                                        </span>
                                        <span class="author-meta">
                                            <span class="post-name"><a href="author.html">${publicacion.Nombre_usuario}</a></span><br/>
                                            <span class="post-date">${formattedFecha}</span>
                                        </span>
                                        <span class="post-read-more"><a href="post.html" title="Read Story"><svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25"><path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path></svg></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#publicaciones-container').append(publicacionHTML);
            });
        } else {
            // Manejar el caso en que no haya publicaciones disponibles para la categoría "Francia"
            $('#publicaciones-container').html('<p>No hay publicaciones disponibles para la categoría "Francia".</p>');
        }
    },
    error: function(error) {
        // Manejar errores en la petición
        console.error('Error al obtener datos:', error);
        $('#publicaciones-container').html('<p>Error al obtener datos.</p>');
    }
});
