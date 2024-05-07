<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "d52024";
$password = "12345";
$database = "computo";

// Crear conexión
$conecction = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conecction->connect_error) {
    die("Error de conexión: " . $conecction->connect_error);
} else {
//echo json_encode('Conexion exitosa');
}
//Cerrar conexión (opcional, se cerrará automáticamente al final del script)
//$conecction->close();