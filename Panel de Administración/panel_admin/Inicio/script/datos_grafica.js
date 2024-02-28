$(document).ready(function() {
    // Realizar solicitud AJAX para obtener datos desde PHP en el servidor local
    $.ajax({
        url: 'http://localhost/erasmus/backend/obtener_datos/n%c2%ba_usuarios_paises.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length >= 4) {
                // Obtener los porcentajes redondeados
                var porcentajes = data.slice(0, 4).map(function(dato) {
                    return Math.round(dato.porcentaje);
                });

                // Actualizar estilos de las barras de progreso
                porcentajes.forEach(function(porcentaje, index) {
                    var progressBar = $('.bg-gradient-' + (index + 1));
                    progressBar.css('width', porcentaje + '%');
                });

                // Mostrar los nombres y porcentajes en sus respectivos contenedores
                for (var i = 1; i <= 4; i++) {
                    var pais = data[i - 1].pais;
                    var porcentaje = Math.round(data[i - 1].porcentaje);

                    $('#pais' + i).html(pais);
                    $('#porcentaje' + i).html(porcentaje + '%');
                }
            } else {
                // Manejar el caso donde no hay suficientes datos
                console.error('No hay suficientes datos en la respuesta.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
        }
    });
});
