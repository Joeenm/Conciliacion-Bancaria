<?php require "db-conciliacion.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="f_Validaciones.js"></script>
</head>
<body>
    <form id="FR_Reportes" name="FR_Reportes" enctype="multipart/form-data">
       <input type="file" id="archivo" name="archivo" accept=".txt, .dat"> 
       <br>
       <button type="submit" id="Grabar" name="Grabar" onclick="Reportes(event)">
        Grabar
       </button>
    </form>
</body>
</html>
