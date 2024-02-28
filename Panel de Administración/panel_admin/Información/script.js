// Simula la obtención de datos desde un archivo JSON
var datos = '{"nombre_usuario":"Natalia","email":"ngamezb2006@gmail.com","categoria":"Usuario Est\\u00e1ndar"}';

// Intenta parsear la cadena JSON
try {
    // Decodifica las secuencias Unicode escape
    var datosObj = JSON.parse(datos.replace(/\\u([\dA-Fa-f]{4})/g, function (match, group1) {
        return String.fromCharCode(parseInt(group1, 16));
    }));

    // Muestra los datos en la consola para verificar
    console.log(datosObj);

    // Función para mostrar los datos en la página
    function mostrarDatos() {
        document.getElementById("nombreUsuario").textContent = datosObj.nombre_usuario;
        document.getElementById("categoria").textContent = datosObj.categoria;
    }

    // Llama a la función para mostrar los datos al cargar la página
    window.onload = mostrarDatos;

} catch (error) {
    console.error('Error al parsear la cadena JSON:', error);
}
