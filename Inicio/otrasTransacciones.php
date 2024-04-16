<?php require "db-conciliacion.php";?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Otras Transacciones</title>
      <link rel="stylesheet" href="stylesOtrasTransacciones.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script defer src="Validaciones.js"></script>
  </head>
  <body>
  <form id="FROtrasT" name="FROtrasT" >
    <div id="contenido">
        <div id="otrasTransaccionesTitulo">
            <div id="otrasTransacciones">
                <h2>Otras Transacciones - Depósitos, Ajustes y Notas de Crédito</h2>
            </div>
        </div>
        <div class="contenedor-otrasTransacciones">
          <div id="fecha">
            <h2>Fecha</h2>
            <input type="date" id="Fecha" name="Fecha">
          </div>
          <div id="transaccion-monto">
            <div id="transaccion">
              <h2>Transacción</h2>
              <select  type="text" name="transaccion" id="transaccion">
              <optgroup label="Libro">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM transacciones WHERE codigo <= 5 ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
                <optgroup label="Banco">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM transacciones WHERE codigo >= 6 AND codigo <= 7 ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
                <optgroup label="Transferencias">
                  <?php
                    $buscar_objetos_gasto = mysqli_query($conn, "SELECT * FROM transacciones WHERE codigo >= 8 ORDER BY codigo ASC");
                    // Iterar a través de los resultados y generar las opciones HTML
                    while ($objeto_gasto = mysqli_fetch_assoc($buscar_objetos_gasto)) {
                        echo "<option value='" . $objeto_gasto['codigo'] . "'>" . $objeto_gasto['codigo'] . "-" . $objeto_gasto['detalle'] . "</option>";
                    }
                  ?>
                </optgroup>
              </select>
            </div>
            <div id="monto">
              <h2>Monto</h2>
                <input type="text" id="Monto" name="Monto" >
            </div>
          </div>
        </div>
        <!-- Línea divisora -->
        <div class="div-con-linea"></div>
        <div class="contenedor-boton">
          <button class="botones" onclick="OTransacciones(event)" >Grabar</button>
          <button class="botones">Nuevo</button>
        </div>
    </div>
  </form>
  </body>
</html>