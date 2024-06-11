<?php require "db-conciliacion.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia</title>
    <link rel="stylesheet" href="stylesAsistencia.css">
    <link rel="stylesheet" href="stylesNotificacion.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="f_Validaciones.js"></script>
</head>
    <body>
        <form id="FR_Reportes" name="FR_Reportes" enctype="multipart/form-data" method="post">

            <div id="contenido">
                <div id="procesarDatosTitulo">
                    <div id="procesarDatos">
                        <h2>Procesar Datos</h2>
                    </div>
                </div>

                <div class="contenedor-subirArchivo">
                    <div id="subirArchivo">
                        <input type="file" id="archivo" name="archivo" accept=".dat, .txt">
                    </div>

                    <div class="contenedor-boton">
                        <button class="botones" type="submit" id="Grabar" name="Grabar" onclick="Reportes(event)">Procesar Datos</button>
                        <div class="contenedor-boton2">
                            <input type="text" id="hiddenInput" value="Guardando datos..." readonly>
                        </div>
                        <div class="spinner" id="loadingSpinner"></div>
                    </div>
                </div>

                <!-- Línea divisora -->
                <div class="div-con-linea"></div>

                <div id="procesarDatosTitulo">
                    <div id="procesarDatos">
                        <h2>Reportes</h2>
                    </div>
                </div>

                <div id="contenedorReportes">

                    <div id="desde">
                    <h2>Desde</h2>
                    <input type="date" name="Fecha1" id="Fecha1">
                    </div>

                    <div id="hasta">
                    <h2>Hasta</h2>
                    <input type="date" name="Fecha2" id="Fecha2">
                    </div>

                    <div id="nombre">
                        <h2>Nombre</h2>
                        <select type="text" name="Nombre" id="Nombre">
                            <?php
                            $Buscar_Nombre = mysqli_query($conn, "SELECT * FROM rrhh ORDER BY nombre1 ASC");
                            // Iterar a través de los resultados y generar las opciones HTML
                            while ($Nombre = mysqli_fetch_assoc($Buscar_Nombre)) {
                                $nombreCompleto = $Nombre['nombre1'] . " " . $Nombre['apellido1'];
                                echo "<option value='" . $nombreCompleto . "'>" . $nombreCompleto . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="contenedor-boton">
                        <button class="botones botones-margen-top" type="button" onclick="PedirReporte(event)" >Buscar</button>
                        <div class="spinner2" id="loadingSpinner2"></div>
                    </div>
                    
                </div>

                <div id="toast-notification" class="toast">
                    <span class="toast-icon">ℹ️</span>
                    <span class="toast-message"></span>
                </div>

            </div>

        </form>
    </body>
</html>
