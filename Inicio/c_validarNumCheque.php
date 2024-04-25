<?php
include 'db-conciliacion.php';

// Obtener los datos del formulario
global $conn;
$NoCheque = trim($_POST['input-numero-cheque']);

// Verificar si el número de cheque existe en la base de datos
$sql_check = "SELECT * FROM cheques WHERE numero_cheque = '$NoCheque'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // El número de cheque ya existe en la base de datos
    echo json_encode(array('error' => 'El número de cheque ya existe. Favor de corregir.'));
} else {
    // El número de cheque no existe en la base de datos
    echo json_encode(array('success' => 'El número de cheque es válido para registrar.'));
}