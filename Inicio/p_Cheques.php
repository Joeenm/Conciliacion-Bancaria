<?php require "db-conciliacion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de Cheques</title>
    <link rel="stylesheet" href="stylesCheques.css">
    <link rel="stylesheet" href="stylesNotificacion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="f_Validaciones.js"></script>
</head>
<body>
<form id="FormularioCks" name="FormularioCks" >
  
<div id="titulo">
  <h1>Creación de Cheques</h1>

    <div id="creacion-cheques">
        <div id="cheques">
            <h2>Cheques</h2>        
        </div>
    
        <div id="objetos-gastos">
            <h2>Objetos de Gastos</h2>
        </div>
    </div>

    <div class="contenedor-cheques">
        <div id="contenido-cheques">
          <div id="ck1">
          <div id="numero-cheque">
              <h4>No. de Cheque</h4>
              <input type="text" id="input-numero-cheque" name="input-numero-cheque" onkeypress="return SoloNumeros(event)" onblur="validarNumeroCheque(event)">
          </div>
            
            <div id="fecha">
                <h4>Fecha</h4>
                <input type="date" id="fecha" name="fecha">
            </div>
          </div>
        
          <div id="ck2">
            <h4>Páguese a la orden de</h4>
            <select type="text" id="p-orden-a" name="p-orden-a" >
              <option value=""></option>
            <?php
              $buscar_proveedores = mysqli_query($conn, "SELECT * FROM proveedores ORDER BY nombre ASC");
              // Iterar a través de los resultados y generar las opciones HTML
              while ($proveedor = mysqli_fetch_assoc($buscar_proveedores)) {
                  $seleccionado = "";
                  // $Nombre_actual = "valor"; // Por ejemplo, establecer un valor específico para comparar
                  if ($proveedor['nombre'] == $Nombre_actual) {
                      $seleccionado = "selected"; // Si el nombre del proveedor coincide con $Nombre_actual, se marca como seleccionado
                  }
                  echo "<option value='" . $proveedor['nombre'] . "' $seleccionado>" . $proveedor['nombre'] . "</option>";
              }
              // Cerrar la conexión a la base de datos
             // mysqli_close($conn);
              ?>
            </select>
            <h4>La suma de</h4>
            <input type="text" id="suma-de" name="suma-de" onkeyup="actualizarMonto(); convertirNumeroALetras()" onkeypress="return SoloDinero(event)">
            <input type="text" id="suma" name="suma" placeholder="Cantidad en letras" readonly>
          </div>

          <div id="ck3">
            <h4>Detalle</h4>
            <input type="text" id="DetallesCks" name="DetallesCks" maxlength="100">
          </div>
        </div>
        
        
    <div id="contenido-objeto-gastos">
          <div id="og-1">
              <h4>Objeto</h4>
              <select type="text" id="objeto-1" name="objeto-1" >
                <optgroup label="SERVICIOS NO PERSONALES">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM objeto_gasto WHERE objeto = 1 ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
                <optgroup label="MATERIALES DE SUMINISTROS">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM objeto_gasto WHERE objeto = 2 ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
                <optgroup label="MAQUINARIA Y EQUIPO">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM objeto_gasto WHERE objeto = 3 ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
              </select>
            </div>

            <div id="og-2">
              <h4>Monto</h4>
              <input type="text" id="monto-1" name="monto-1" readonly>
            </div>
          </div>      

    </div>

    <div id="toast-notification" class="toast">
      <span class="toast-icon">ℹ️</span>
      <span class="toast-message"></span>
    </div>

    <div class="contenedor-botones">
      <button class="boton" id="Grabarcks" name="Grabarcks" onclick="GrabaraCKs(event)">Grabar</button>
      <button class="boton">Imprimir</button>
      <button class="boton">Nuevo</button>
    </div>

</div>

</form>
</body>
</html>
