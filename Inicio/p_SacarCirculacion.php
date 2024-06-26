<?php require "db-conciliacion.php";?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sacar Cheques de Circulación</title>
    <link rel="stylesheet" href="stylesSacarCirculacion.css">
    <link rel="stylesheet" href="stylesNotificacion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="f_Validaciones.js"></script>
</head>
<body>
<form id="FRCirculacion" name="FRCirculacion" method="post">

<div id="contenido">
    <div id="sacarCirculacionTitulo">
        <div id="sacarCirculacion">
            <h2>Sacar Cheques de Circulación</h2>
        </div>
    </div>


    <div class="contenedor-sacarCirculacion">
        <div id="contenido-sacarCirculacion">
            
          <div id="ck1">
            <div id="numero-cheque">
                <h4>No. de Cheque</h4>
                <input type="text" id="numero_cheque" name="numero_cheque" onkeypress="return SoloNumeros(event)">
            </div>
            
            <div class="contenedor-botones">
            <button type="button" class="boton" id="boton-ajax" onclick="BusquedaCK()" >Buscar</button>
            </div>
          </div>

          <div id="FCH">
            <div id="Fecha">
                <h4>Fecha</h4>
                <input type="date" id="fecha" name="fecha" readonly>
            </div>  
          </div>

        
          <div id="ck2">
            <h4>Páguese a la orden de</h4>
            <div id="ck2-1">
              <input type="text" id="p-orden-a" name="p-orden-a" readonly>
            </div>
        
            <h4>La suma de</h4>
            <input type="text" id="monto" name="monto" readonly>
           
          </div>

          <div id="ck3">
            <h4>Descripción de Gasto</h4>
            <input type="text" id="descripcion" name="descripcion" readonly>
          </div>
        </div>
        
        <div class="contenedor-detalles-sacarCirculacion">
          <div id="contenido-Detalle-sacarCirculacion">
            <div id="og-1">
              <h4>Fecha/Banco</h4>
              <input type="date" id="objeto-1" name="objeto-1" >
              <button class="boton" onclick="Circulacion(event)">Sacar de Circulación</button>
            </div>
          </div>
        </div>

        <div id="toast-notification" class="toast">
          <span class="toast-icon">ℹ️</span>
          <span class="toast-message"></span>
        </div>

    </div>

</div>
</form>
</body>
</html>