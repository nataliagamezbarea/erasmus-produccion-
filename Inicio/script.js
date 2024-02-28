
function obtenerMaxLikes() {
    fetch('http://localhost/erasmus/backend/obtener_datos/maximo_likes.php')
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al obtener los datos. Código de estado: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        // Obtener el elemento span por su clase
        const spanElement = document.querySelector('.max-likes');
  
        // Acceder al valor correcto del JSON (max_likes) y actualizar el contenido del span
        spanElement.dataset.number = data.max_likes;
        spanElement.textContent = data.max_likes;
      })
      .catch(error => {
        console.error(error.message);
      });
  }
  
  // Llamar a la función para realizar la consulta cuando la página cargue
  document.addEventListener('DOMContentLoaded', obtenerMaxLikes);

  function obtenerNumeroPaises() {
    fetch('http://localhost/erasmus/backend/obtener_datos/numero_paises.php')
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al obtener los datos. Código de estado: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        // Obtener el elemento span por su clase
        const spanElement = document.querySelector('.total-paises');
  
        // Acceder al valor correcto del JSON (total_paises) y actualizar el contenido del span
        spanElement.dataset.number = data.total_paises;
        spanElement.textContent = data.total_paises;
      })
      .catch(error => {
        console.error(error.message);
      });
  }
  
  // Llamar a la función para realizar la consulta cuando la página cargue
  document.addEventListener('DOMContentLoaded', obtenerNumeroPaises);
  
  $(document).ready(function() {
    // Realizar la solicitud HTTP
    $.ajax({
        url: 'http://localhost/erasmus/backend/obtener_datos/numero_publicaciones.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Actualizar el contenido del marcador de posición con el resultado
            $('.total-publicaciones').text(response.total);
        },
        error: function(error) {
            console.error('Error al obtener el número de publicaciones:', error);
        }
    });
});

document.addEventListener('DOMContentLoaded', obtenerNumeroPublicaciones);

  function obtenerNumeroPublicaciones() {
    fetch('http://localhost/erasmus/backend/obtener_datos/numero_publicaciones.php')
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al obtener los datos. Código de estado: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        const spanElement = document.querySelector('.total-publicaciones');
        spanElement.dataset.number = data.total;
        spanElement.textContent = data.total;
      })
      .catch(error => {
        console.error('Error al obtener el número de publicaciones:', error);
      });
  }

  document.addEventListener('DOMContentLoaded', obtenerTotalCuentas);

  function obtenerTotalCuentas() {
    fetch('http://localhost/erasmus/backend/obtener_datos/obtener_total_usuarios.php')
      .then(response => {
        if (!response.ok) {
          throw new Error(`Error al obtener los datos. Código de estado: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        const spanElement = document.querySelector('.total-usuarios');
        spanElement.dataset.number = data.total_cuentas;
        spanElement.textContent = data.total_cuentas;
      })
      .catch(error => {
        console.error('Error al obtener el número total de cuentas:', error);
      });
  }