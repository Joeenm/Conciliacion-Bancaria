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
    <title>Creación de Cheques</title>
    <link rel="stylesheet" href="stylesCheques.css">
    <script src="validaciones.js"></script>
</head>
<body>

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
                <input type="text" id="input-numero-cheque" onkeypress="return SoloNumeros(event)">
            </div>
            
            <div id="fecha">
                <h4>Fecha</h4>
                <input type="date" id="fecha">
            </div>
          </div>
        
          <div id="ck2">
            <h4>Páguese a la orden de</h4>
            <select type="text" id="p-orden-a">
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
            <input type="text" id="suma-de" onkeyup="actualizarMonto()" onkeypress="return SoloDinero(event)">
            <input type="text" id="suma" placeholder="Cantidad en letras" onkeypress="return SoloLetras(event)">
          </div>

          <div id="ck3">
            <h4>Detalle</h4>
            <input type="text" maxlength="100">
          </div>
        </div>
        
        
    <div id="contenido-objeto-gastos">
          <div id="og-1">
              <h4>Objeto</h4>
              <select type="text" id="objeto-1">
                <optgroup label="SERVICIOS NO PERSONALES">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM objeto_gasto WHERE codigo >= '120' AND codigo < '200' ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
                <optgroup label="MATERIALES DE SUMINISTROS">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM objeto_gasto WHERE codigo >= '200' AND codigo < '320' ORDER BY codigo ASC");
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
              <input type="text" id="monto-1" readonly>
            </div>
          </div>      

    </div>

    <div class="contenedor-botones">
      <button class="boton">Grabar</button>
      <button class="boton">Imprimir</button>
      <button class="boton">Nuevo</button>
    </div>

</div>

</body>
</html>