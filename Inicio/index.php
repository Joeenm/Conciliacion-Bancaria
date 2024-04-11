<?php require "db-conciliacion.php";?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conciliación Bancaria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="styles.css">
    <script src="reloj.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Validaciones.js"></script>
    <script src="cargaElementos.js" defer></script>
  </head>
  <body>
    <nav class="navbar">
      <div class="logo">
        <i class="fa-solid fa-font-awesome"></i>
        <a href="#">QA Insurance</a>
      </div>
      <div class="menu">
        <div class="menu-links">
          <a href="#" onclick="cargarInicio()">Inicio</a>
          <a href="#" onclick="cargarCheques()">Cheques</a>
          <div class="Caja-D">
          <a>Operaciones Cks</a>
          <ul class="OP-Caja">
            <li><a href="#" onclick="cargarAnulacionesCks()">Anulación</a></li>
            <li><a href="#" onclick="cargarSacarCirulacion()">Sacar de Circulación</a></li>
          </ul>
        </div>
          <a href="#" onclick="cargarOtrasTransacciones()">Otras Transacciones</a>
          <a href="#" onclick="cargarConciliacion()">Conciliación</a>
          <a href="#" onclick="cargarReportes()">Reportes</a>
          <a href="#" onclick="cargarMantenimiento()">Mantenimiento</a>
        </div>
        <div id="reloj"></div>
      </div>
      <div class="menu-btn">
        <i class="fa-solid fa-bars"></i>
      </div>
    </nav>
    <div id="contenido">

    </div>
  </body>
</html>