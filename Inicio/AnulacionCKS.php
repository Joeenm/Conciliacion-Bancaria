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
    <title>Anulación de Cheques</title>
    <link rel="stylesheet" href="StyleAnulacion.css">
    <script src="Validaciones.js" defer></script>
</head>
<body>

<div id="titulo">
  <h1>Anulación de Cheques</h1>


    <div class="contenedor-cheques">
        <div id="contenido-cheques">
            
          <div id="ck1">
            <div id="numero-cheque">
                <h4>No. de Cheque</h4>
                <input type="text" id="numero-cheque" onkeypress="return SoloNumeros(event)">
            </div>
            
            <div class="contenedor-botones">
                <button class="boton">Buscar</button>
              </div>
          
          </div>

          <div id="FCH">
            <div id="Fecha">
                <h4>Fecha</h4>
                <input type="date" id="Fecha" readonly>
            </div>  
          </div>

        
          <div id="ck2">
            <h4>Páguese a la orden de</h4>
            <div id="ck2-1">
              <input type="text" id="p-orden-a" readonly>
            </div>
        
            <h4>La suma de</h4>
            <input type="text" readonly>
           
          </div>

          <div id="ck3">
            <h4>Descripción de Gasto</h4>
            <input type="text" readonly>
          </div>
        </div>
        
        <div class="contenedor-detalles-Anulación">
          <div id="contenido-Detalle-Anulación">
            <div id="og-1">
              <h4>Fecha de Anulación</h4>
              <input type="date" id="objeto-1" readonly>
              <h4>Detalle de Anulación</h4>
              <input type="text" id="Objeto-2" readonly >
              <button class="boton">Anular</button>
            </div>
          </div>

        </div>

    </div>

</div>

</body>
</html>