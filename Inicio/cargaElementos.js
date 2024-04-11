function cargarInicio() {
  window.location.href = 'index.php';
}

  function cargarCheques() {
    fetch('cheques.php')
      .then(response => response.text())
      .then(data => {
        document.getElementById('contenido').innerHTML = data;
      })
      .catch(error => console.error('Error al cargar la página:', error));
  }

  function cargarAnulacionesCks() {
    console.log("Función cargarAnulacionesCks() llamada");
    fetch('AnulacionCKS.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
}

  function cargarSacarCirulacion() {
    fetch('sacarCirculacion.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
  }

  function cargarOtrasTransacciones() {
    fetch('otrasTransacciones.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
  }

  function cargarConciliacion() {
    fetch('conciliacion.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
  } 

  function cargarReportes() {
    document.getElementById('contenido').innerHTML = 'Contenido de Reportes';
  }

  function cargarMantenimiento() {
    document.getElementById('contenido').innerHTML = 'Contenido de Mantenimiento';
  }