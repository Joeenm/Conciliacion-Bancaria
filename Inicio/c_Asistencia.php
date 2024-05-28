<?php
require "db-conciliacion.php";

global $conn;
$Ruta= $_FILES['archivo']['tmp_name'];
$Archivo= fopen($Ruta, 'r');
while (($Fila=fgets($Archivo)) !== False) {
   
    $codigo = trim(substr($Fila,0,10)); // Sanitiza el código 7
    $fecha = trim(substr($Fila,12,10)); // Sanitiza la fecha 10
    $hora = trim(substr($Fila,22,9)); // Sanitiza la hora 11
    $filler1 = trim(substr($Fila,30,1)); // Sanitiza filler1 12
    $filler2 = trim(substr($Fila,32,2)); // Sanitiza filler2 15
    $filler3 = trim(substr($Fila,34,2)); // Sanitiza filler3 18
    $filler4 = trim(substr($Fila,36,3)); // Sanitiza filler4 21

    $sql= mysqli_query($conn, "INSERT INTO `datos` (`codigo`, `fecha`, `hora`, `filler1`, `filler2`, `filler3`, `filler4`) 
    VALUES ('$codigo', '$fecha', '$hora', '$filler1', '$filler2', '$filler3', '$filler4')");
}    
if ($sql) {
    echo json_encode(array('success' => 'La inserción fue grabada con éxito.'));
} else {
    echo json_encode(array('error' => $conn->error));
}