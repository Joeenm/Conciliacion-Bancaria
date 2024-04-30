<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "d52024";
$password = "12345";
$database = "conciliacion";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
  //echo "<script>console.log('Conexión exitosa');</script>";
}
//Cerrar conexión (opcional, se cerrará automáticamente al final del script)
//$conn->close();