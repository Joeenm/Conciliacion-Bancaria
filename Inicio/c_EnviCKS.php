<?php
include 'db-conciliacion.php';

// Obtener los datos del formulario
global $conn;
$NoCheque = trim($_POST['input-numero-cheque']);

    // El número de cheque no existe, proceder con la inserción
    $FechaCks = trim($_POST['fecha']);
    $Beneficiarios = trim($_POST['p-orden-a']);
    $CodBen = "SELECT * FROM proveedores WHERE nombre = '$Beneficiarios'";
    $ResulBen = $conn->query($CodBen);
    $row = $ResulBen->fetch_assoc();
    $codigoBen = $row['codigo'];
    $Monto = trim($_POST['suma-de']);
    $Detalle = trim($_POST['DetallesCks']);
    $Objeto1 = trim($_POST['objeto-1']);
    $MontoObj = trim($_POST['monto-1']);

    $sql_insert = "INSERT INTO cheques (`numero_cheque`, `fecha`, `beneficiario`, `monto`, `descripcion`, `fecha_anulado`, `detalle_anulado`, `fecha_circulacion`, `fecha_reintegro`, `codigo_objeto1`, `monto_objeto1`) VALUES ('$NoCheque', '$FechaCks','$codigoBen','$Monto','$Detalle', '', '', '', '', '$Objeto1', '$MontoObj')";
    
    if ($conn->query($sql_insert) === TRUE) {
        // La inserción fue exitosa
        echo json_encode(array('success' => 'La inserción fue exitosa.'));
    } else {
        // Error al insertar en la base de datos
        echo json_encode(array('error' => 'Error al insertar en la base de datos.'));
    }
