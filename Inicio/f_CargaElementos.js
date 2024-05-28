function cargarInicio() {
  window.location.href = 'index.php';
}

  function cargarCheques() {
    fetch('p_Cheques.php')
      .then(response => response.text())
      .then(data => {
        document.getElementById('contenido').innerHTML = data;
      })
      .catch(error => console.error('Error al cargar la página:', error));
  }

  function cargarAnulacionesCks() {
    console.log("Función cargarAnulacionesCks() llamada");
    fetch('p_Anulacion.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
}

  function cargarSacarCirulacion() {
    fetch('p_SacarCirculacion.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
  }

  function cargarOtrasTransacciones() {
    fetch('p_OtrasTransacciones.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('contenido').innerHTML = data;
        })
        .catch(error => console.error('Error al cargar la página:', error));
  }

  function cargarConciliacion() {
    fetch('p_Conciliacion.php')
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

  function cargarAsistencia(){
    fetch('p_Asistencia.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('contenido').innerHTML = data;
    })
    .catch(error => console.error('Error al cargar la página:', error));
} 