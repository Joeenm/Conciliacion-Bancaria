<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conciliación Bancaria</title>
    <link rel="stylesheet" href="stylesConciliacion.css">
    <script src=""></script>
</head>
<body>

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
              <input type="text">
            </div>

            <div id="año">
              <h2>Año</h2>
              <input type="text">
            </div>
        </div>

        <div class="contenedor-boton">
          <div class="primer-boton"><button class="botones">Realizar Conciliación</button></div>
        </div>
    </div>

    <!-- Línea divisora -->
    <div class="div-con-linea"></div>

    <div class="div-3x6">
        <!-- Primera fila -->
        <div id="libro-1"><h2>SALDO SEGÚN LIBRO AL: </h2></div>
        <div></div>
        <div><input type="text"></div>
        <div id= libro-2><h2>Más: Depósito</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
    
        <!-- Segunda fila -->
        <div id="libro-3"><h2>Cheques Anulados</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
        <div id="libro-4"><h2>Notas de Crédito</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
    
        <!-- Tercera fila -->
        <div id="libro-5"><h2>Ajustes</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>

        <!-- Cuarta Fila -->
        <div></div>
        <div id="subtotal"><h2>Subtotal</h2></div>
        <div><input type="text"></div>
        <div id="primer-subtotal"><h2>SUBTOTAL</h2></div>
        <div></div>
        <div><input type="text"></div>

        <!-- Quinta Fila -->
        <div id= libro-6><h2>Menos: Cheques girados en el mes</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
        <div id="libro-7"><h2>Notas de Débitos</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>

        <!-- Sexta Fila -->
        <div id="libro-8"><h2>Ajustes</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>

        <!-- Séptima fila -->
        <div></div>
        <div id="subtotal"><h2>Subtotal</h2></div>
        <div><input type="text"></div>
        <div id="saldo-libro-final"><h2>SALDO CONCILIADO SEGÚN LIBROS AL: </h2></div>
        <div></div>
        <div><input type="text"></div>
    </div>

    <!-- Línea divisora -->
    <div class="div-con-linea"></div>
<!-- /////////////////////////////////////////////////////// -->
    <div class="div-3x6">
        <!-- Primera fila -->
        <div id="banco-1"><h2>SALDO EN BANCO AL: </h2></div>
        <div></div>
        <div><input type="text"></div>
        <div id= banco-2><h2>Más: Depósitos en Tránsito</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
    
        <!-- Segunda fila -->
        <div id="banco-3"><h2>Menos: Cheques en Circulación</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
        <div id="banco-4"><h2>Más: Ajustes</h2></div>
        <div id="subtotal"><input type="text" class="input-derecha"></div>
        <div></div>
    
        <!-- Tercera fila -->
        <div></div>
        <div id="subtotal"><h2>Subtotal</h2></div>
        <div><input type="text"></div>
        <div id="saldo-banco-final"><h2>SALDO CONCILIADO IGUAL A BANCO AL: </h2></div>
        <div></div>
        <div><input type="text"></div>
    </div>
<!-- /////////////////////////////////////////////////////// -->
    <!-- Línea divisora -->
    <div class="div-con-linea"></div>

    <div class="contenedor-botones">
      <button class="botones">Grabar</button>
      <button class="botones">Nuevo</button>
    </div>
    
  
</div>

</body>
</html>