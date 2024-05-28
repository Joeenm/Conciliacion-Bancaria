<?php require "db-conciliacion.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
    <link rel="stylesheet" href="stylesAsistencia.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="f_Validaciones.js"></script>
</head>
<body>
    <form id="FR_Reportes" name="FR_Reportes" enctype="multipart/form-data" method="post">

    <div id="Cuerpo">
        
        <div id="Global" name="Global" class="Global">
            <div id="EncabezadoDatos" name="EncabezadoDatos" class="EncabezadoDatos">
                <Label>Procesar Datos</Label>
            </div>

            <div id="SubirArchivos" name="SubirArchivos" class="SubirArchivos" >
            <input type="file" id="archivo" name="archivo" accept=".dat">
            <button type="submit" id="Grabar" name="Grabar" onclick="Reportes(event)">
                Grabar
            </button>
            </div>
        </div>

        <div>
            <div id="EncabezadoRep" name="EncabezadoRep" class="EncabezadoRep" >
                <label>Reportes</label>
            </div>

            <div id="Report" name="Report" class="Report" >
                <div id="CDesde" name="CDesde" class="CDesde" >
                    <label for="">Desde</label>
                    <input type="date" name="Fecha1" id="Fecha1">
                </div>
                
                <div id="CHasta" name="CHasta" class="CHasta">
                    <label for="">Hasta</label>
                    <input type="date" name="Fecha2" id="Fecha2">
                </div>

                <div id="CNombre" name="CNombre" class="CNombre">
                    <label for="">Nombre</label>
                    <select type="text" name="Nombre" id="Nombre">
                        <?php
                        $Buscar_Nombre = mysqli_query($conn, "SELECT * FROM rrhh ORDER BY nombre1 ASC");
                        // Iterar a través de los resultados y generar las opciones HTML
                        while ($Nombre = mysqli_fetch_assoc($Buscar_Nombre)) {
                            echo "<option value='" . $Nombre['nombre1'] . "'>" . $Nombre['nombre1'] . " " . $Nombre['apellido1'] . "</option>";
                        }
                        ?>
                    </select>
                    <button type="button" onclick="PedirReporte(event)" >Buscar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>
