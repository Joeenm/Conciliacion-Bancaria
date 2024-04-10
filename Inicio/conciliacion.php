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
          <button class="realizarConciliacion">Realizar Conciliación</button>
        </div>
    </div>

    <div id="saldo-libro">
       <div id="libro-1">
        <h2>SALDO SEGÚN LIBRO AL: </h2>
        <input type="text">
       </div>
    </div>

    <div id="libro-2">
      <div id="mas">
        <div class="sangria-mas-y-menos" id="deposito">
            <div><h2>Más: Depósito</h2></div>
            <div class="sangria-input-deposito"><input type="text"></div>
        </div>

        <div class="sangria" id="cheques-anu">
            <div><h2>Cheques Anulados</h2></div>
            <div class="sangria-input-cheque-anu"><input type="text"></div>
        </div>

        <div class="sangria" id="ajustes">
            <div><h2>Ajustes</h2></div>
            <div class="sangria-input-ajuste"><input type="text"></div>
        </div>
      </div>

      <div id="subtotal">
        <div id="subtotal-mas">
          <div><h2>Subtotal de +</h2></div>
          <div><input type="text"></div>
        </div>

        <div id="subtotal-1">
          <div><h2>SUBTOTAL</h2></div>
          <div><input type="text"></div>
        </div>
      </div>
    </div>

    <div id="libro-3">
    <div id="menos">
        <div class="sangria-mas-y-menos" id="">
            <div><h2>Menos: Cheques girados <br>en el mes</h2></div>
            <div class=""><input type="text"></div>
        </div>

        <div class="sangria" id="">
            <div><h2>Notas de Débitos</h2></div>
            <div class="sangria-input-nota-debito"><input type="text"></div>
        </div>

        <div class="sangria" id="ajustes">
            <div><h2>Ajustes</h2></div>
            <div class="sangria-input-ajuste"><input type="text"></div>
        </div>
    </div>

    <div id="subtotal">
      <div id="subtotal-menos">
        <div><h2>Subtotal de -</h2></div>
        <div><input type="text"></div>
      </div>
    </div>
  
</div>

<div id="saldo-libro-final">
  <div id="libro-1">
    <h2>SALDO CONCILIADO SEGÚN LIBROS AL: </h2>
    <input type="text">
  </div>
</div>

<!-- Línea divisora -->
<div class="div-con-linea">
</div>

<div id="saldo-banco">
  <div id="banco-1">
    <div><h2>SALDO EN BANCO AL: </h2></div>
    <div><input type="text"></div>
  </div>
</div>


</body>
</html>