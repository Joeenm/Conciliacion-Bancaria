<?php require "db-conciliacion.php"; 
$age_Actual=Date('Y');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conciliación Bancaria</title>
    <link rel="stylesheet" href="stylesConciliacion.css">
    <link rel="stylesheet" href="stylesNotificacion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="f_Validaciones.js">
        
    </script>
</head>
<body>
<form id="FRConciliacion" name="FRConciliacion" method="post">
<div id="contenido">
    <div id="creacion-conciliacion">
        <div id="conciliacion">
            <h2>Conciliación Bancaria</h2>
        </div>
    </div>

    <div id="centro">
        <div id="mes-año">
            <div id="mes">
              <h2>Mes</h2>
              <select id="Selectmes" name="Selectmes" type="text">
              <?php
                 $buscar_Mes = mysqli_query($conn, "SELECT * FROM meses ORDER BY mes ASC");
                 // Iterar a través de los resultados y generar las opciones HTML
                 while ($Mes = mysqli_fetch_assoc($buscar_Mes)) {
                     $seleccionado = "";
                     // $Nombre_actual = "valor"; // Por ejemplo, establecer un valor específico para comparar
                     if ($Mes['nombre_mes'] == $Nombre_actual) {
                         $seleccionado = "selected"; // Si el nombre del proveedor coincide con $Nombre_actual, se marca como seleccionado
                     }
                     echo "<option value='" . $Mes['nombre_mes'] . "' $seleccionado>" . $Mes['nombre_mes'] . "</option>";
                 }
                ?>
              </select> 
            </div>

            <div id="año">
              <h2>Año</h2>
              <select id="age" name="age" type="text">
              <?php
                $Age_Superior = $age_Actual+1; 
                $Age_Inferior = $age_Actual-5; 
                for ($X=$Age_Superior;$X>=$Age_Inferior;$X--){
                  $seleccionado="";
                  if($X==$age_Actual){
                    $seleccionado="selected";
                  }
                  echo "<option value='" .$X. "' $seleccionado>" .$X. "</option>";
                }
                $seleccionado="";
              ?>
              </select> 
            </div>
        </div>

        <div class="contenedor-boton">
          <div class="primer-boton" >
            <button type="button" onclick="MostrarConciliacion()" class="botones">Realizar Conciliación</button>
        </div>
        </div>
    </div>

    <!-- Línea divisora -->
    <div class="div-con-linea"></div>

    <div class="div-3x6">
        <!-- Primera fila -->
        <div id="libro-1">
            <h2 id="Libro_Pasado" name= "Libro_Pasado">SALDO SEGÚN LIBRO AL </h2>
            <!-- Input ocultos para facilitar en envio del formulario -->
            <input type="hidden" id="Dia-Anterior_oculto" name="Dia-Anterior_oculto">
            <input type="hidden" id="Mes-Anterior_oculto" name="Mes-Anterior_oculto">
            <input type="hidden" id="Año-Anterior_oculto" name="Año-Anterior_oculto">
            <input type="hidden" id="Dia-Actual_oculto" name="Dia-Actual_oculto">
            <input type="hidden" id="Mes-Actual_oculto" name="Mes-Actual_oculto">
            <input type="hidden" id="Año-Actual_oculto" name="Año-Actual_oculto">
        </div>
        <div></div>
        <div>
            <input id="libro_1" name="libro_1" type="text" readonly>
        </div>
        <div id= "libro-2" ><h2>Más: Depósito</h2></div>
        <div id="subtotal">
            <input id="Depósito" name="Depósito"  type="text" class="input-derecha" readonly></div>
        <div></div>
    
        <!-- Segunda fila -->
        <div id="libro-3"><h2>Cheques Anulados</h2></div>
        <div id="subtotal">
            <input id="Cheques-Anulados" name="Cheques-Anulados" type="text" class="input-derecha" readonly></div>
        <div></div>
        <div id="libro-4"><h2>Notas de Crédito</h2></div>
        <div id="subtotal">
            <input id="Notas-de-Crédito" name="Notas-de-Crédito" type="text" class="input-derecha" readonly></div>
        <div></div>
    
        <!-- Tercera fila -->
        <div id="libro-5"><h2>Ajustes</h2></div>
        <div id="subtotal">
            <input id="Ajustes" name="Ajustes" type="text" class="input-derecha" readonly></div>
        <div></div>

        <!-- Cuarta Fila -->
        <div></div>
        <div id="subtotal"><h2>Subtotal</h2></div>
        <div>
            <input id="Subtotal" name="Subtotal"  type="text" readonly></div>
        <div id="primer-subtotal"><h2>SUBTOTAL</h2></div>
        <div></div>
        <div>
            <input  id="SUB_TOTAL" name="SUB_TOTAL" type="text" readonly>
        </div>

        <!-- Quinta Fila -->
        <div id= libro-6><h2>Menos: Cheques girados en el mes</h2></div>
        <div id="subtotal">
            <input id="Cheques-girados" name="Cheques-girados" type="text" class="input-derecha" readonly></div>
        <div></div>
        <div id="libro-7"><h2>Notas de Débitos</h2></div>
        <div id="subtotal">
            <input id="Notas-Débitos" name="Notas-Débitos" type="text" class="input-derecha" readonly></div>
        <div></div>

        <!-- Sexta Fila -->
        <div id="libro-8"><h2>Ajustes</h2></div>
        <div id="subtotal">
            <input id="Ajustes2" name="Ajustes2" type="text" class="input-derecha" readonly></div>
        <div></div>

        <!-- Séptima fila -->
        <div></div>
        <div id="subtotal"><h2>Subtotal</h2></div>
        <div>
            <input id="Subtotal2" name="Subtotal2" type="text" readonly></div>
        <div id="saldo-libro-final">
            <h2 id ="LibroActual" name="LibroActual">SALDO CONCILIADO SEGÚN LIBRO AL </h2>
        </div>
        <div></div>
        <div>
            <input id="SALDO_CONCILIADO" name="SALDO_CONCILIADO" type="text" readonly></div>
    </div>

    <!-- Línea divisora -->
    <div class="div-con-linea"></div>
<!-- /////////////////////////////////////////////////////// -->
    <div class="div-3x6">
        <!-- Primera fila -->
        <div id="banco-1"><h2 id ="LibroActual1" name="LibroActual1">SALDO EN BANCO AL  </h2></div>
        <div></div>
        <div>
            <input id="SALDO_BANCO" name="SALDO_BANCO" type="text" onkeypress="return SoloDinero(event) && SumaConciliacion(event);" disabled  ></div>
        <div id= banco-2><h2>Más: Depósitos en Tránsito</h2></div>
        <div id="subtotal">
            <input id="Depósitos-Tránsito" name="Depósitos-Tránsito" type="text" class="input-derecha" readonly></div>
        <div></div>
    
        <!-- Segunda fila -->
        <div id="banco-3"><h2>Menos: Cheques en Circulación</h2></div>
        <div id="subtotal">
            <input id="Cheques_en_Circulación" name="Cheques_en_Circulación" type="text" class="input-derecha" readonly></div>
        <div></div>
        <div id="banco-4"><h2>Más: Ajustes</h2></div>
        <div id="subtotal">
            <input id="Ajustes3" name="Ajustes3" type="text" class="input-derecha" readonly></div>
        <div></div>
    
        <!-- Tercera fila -->
        <div></div>
        <div id="subtotal"><h2>Subtotal</h2></div>
        <div>
            <input id="Subtotal3" name="Subtotal3" type="text" readonly></div>
            <input type="hidden" id="sub3V" name="sub3V" >
        <div id="saldo-banco-final"><h2 id ="LibroActual2" name="LibroActual2">SALDO CONCILIADO IGUAL A BANCO AL </h2></div>
        <div></div>
        <div>
            <input id="SaldoT" name="SaldoT" type="text" readonly></div>
    </div>
<!-- /////////////////////////////////////////////////////// -->
    <!-- Línea divisora -->
    <div class="div-con-linea"></div>
    
    
    <div id="toast-notification" class="toast">
      <span class="toast-icon">ℹ️</span>
      <span class="toast-message"></span>
    </div>

    <div class="contenedor-botones">
      <button type ="button" class="botones" onclick="GrabarConciliacion (event) ">Grabar</button>
      <button type ="button" class="botones">Nuevo</button>
    </div>
    
  
</div>

</form>
</body>
</html>


