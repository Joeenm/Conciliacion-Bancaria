<?php
require "db-conciliacion.php";

global $conn;
$Ruta= $_FILES['archivo']['tmp_name'];
$Archivo= fopen($Ruta, 'r');
while (($Fila=fgets($Archivo)) !== False) {
   
    $codigo = trim(substr($Fila,0,10)); // Sanitiza el código 7
    $fecha = trim(substr($Fila,12,22)); // Sanitiza la fecha 10
    $hora = trim(substr($Fila,23,32)); // Sanitiza la hora 11
    $filler1 = trim(substr($Fila,33)); // Sanitiza filler1 12
    $filler2 = trim(substr($Fila,36,37)); // Sanitiza filler2 15
    $filler3 = trim(substr($Fila,40,41)); // Sanitiza filler3 18
    $filler4 = trim(substr($Fila,44,45)); // Sanitiza filler4 21
    
    $sql= mysqli_query($conn, "INSERT INTO `datos` (`codigo`, `fecha`, `hora`, `filler1`, `filler2`, `filler3`, `filler4`) 
    VALUES ('$codigo', '$fecha', '$hora', '$filler1', '$filler2', '$filler3', '$filler4')");
}    
if ($sql) {
    echo json_encode(array('success' => 'La inserción fue grabada con éxito.'));
} else {
    echo json_encode(array('error' => $conn->error));
}