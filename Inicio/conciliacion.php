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

    <div id="contendero-tabla">
        <table id="miTabla">
          <tr>
            <td>SALDO SEGÚN LIBRO AL</td>
            <td></td>
            <td><input type="text"></td>
            
          <tr>
            <td>Más: depósito</td>
            <td><input type="text"></td>
            <td></td>
    
          </tr>
          <tr>
            <td><div class="sangria">Cheques Anulados</div></td>
            <td><input type="text"></td>
            <td></td>
          </tr>
    
        </table>
    </div>
    

</div>

</body>
</html>