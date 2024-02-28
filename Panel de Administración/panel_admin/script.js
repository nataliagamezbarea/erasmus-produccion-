// script.js
document.addEventListener('DOMContentLoaded', function () {
    cargarRegistros();
  });
  
  function cargarRegistros() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'obtener_usuarios.php', true);
  
    xhr.onload = function () {
      if (xhr.status === 200) {
        const registros = JSON.parse(xhr.responseText);
        mostrarRegistros(registros);
      } else {
        console.error('Error al cargar los registros');
      }
    };
  
    xhr.send();
  }
  
  function mostrarRegistros(registros) {
    const tablaBody = document.querySelector('#tabla tbody');
    tablaBody.innerHTML = '';
  
    registros.forEach(registro => {
      const fila = document.createElement('tr');
      fila.innerHTML = `
        <td>${registro.id}</td>
        <td>${registro.nombre_usuario}</td>
        <td>${registro.email}</td>
        <td>${registro.categoria}</td>
        <td>${registro.pais ? registro.pais : '-'}</td>
        <td>
          <span class="btn-editar" onclick="abrirModal(${registro.id},'${registro.nombre_usuario}','${registro.email}','${registro.categoria}','${registro.pais ? registro.pais : ''}')">Editar</span>
          <span class="btn-eliminar" onclick="eliminarRegistro(${registro.id})">Eliminar</span>
        </td>
      `;
      tablaBody.appendChild(fila);
    });
  }
  
  function abrirModal(id, nombreUsuario, email, categoria, pais) {
    const modal = document.getElementById('modal');
    const formulario = document.getElementById('formulario-edicion');
  
    document.getElementById('idUsuario').value = id;
    document.getElementById('nombreUsuario').value = nombreUsuario;
    document.getElementById('email').value = email;
    document.getElementById('categoria').value = categoria;
    document.getElementById('pais').value = pais;
  
    modal.style.display = 'block';
  
    formulario.addEventListener('submit', function (event) {
      event.preventDefault();
      const idUsuario = document.getElementById('idUsuario').value;
      const nombreUsuario = document.getElementById('nombreUsuario').value;
      const email = document.getElementById('email').value;
      const categoria = document.getElementById('categoria').value;
      const pais = document.getElementById('pais').value;
  
      // Realizar una solicitud AJAX para enviar los datos de edición al backend
      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'editar_usuario.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
        if (xhr.status === 200) {
          console.log(xhr.responseText);
          // Cerrar el modal y recargar la tabla
          cerrarModal();
          cargarRegistros(); // Asegúrate de tener la función cargarRegistros implementada
        } else {
          console.error('Error al editar el usuario');
        }
      };
      const data = `idUsuario=${idUsuario}&nombreUsuario=${nombreUsuario}&email=${email}&categoria=${categoria}&pais=${pais}`;
      xhr.send(data);
    });
  }
  
  function cerrarModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none';
  }
  