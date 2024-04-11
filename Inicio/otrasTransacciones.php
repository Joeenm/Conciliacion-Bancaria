<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "d52024";
$password = "12345";
$database = "conciliación";
// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);
?>

<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Otras Transacciones</title>
      <link rel="stylesheet" href="stylesOtrasTransacciones.css">
      <script src="Validaciones.js" defer></script>
  </head>
  <body>
    <div id="contenido">
        <div id="otrasTransaccionesTitulo">
            <div id="otrasTransacciones">
                <h2>Otras Transacciones - Depósitos, Ajustes y Notas de Crédito</h2>
            </div>
        </div>
        <div class="contenedor-otrasTransacciones">
          <div id="fecha">
            <h2>Fecha</h2>
            <input type="date" id="Fecha">
          </div>
          <div id="transaccion-monto">
            <div id="transaccion">
              <h2>Transacción</h2>
              <input type="text">
                <option value=""></option>
            </div>
            <div id="monto">
              <h2>Monto</h2>
                <input type="text">
            </div>
          </div>
        </div>
        <!-- Línea divisora -->
        <div class="div-con-linea"></div>
        <div class="contenedor-boton">
          <button class="botones">Grabar</button>
          <button class="botones">Nuevo</button>
        </div>
    </div>
  </body>
</html>