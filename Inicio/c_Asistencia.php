<?php
require "db-conciliacion.php";

$Ruta = $_FILES['archivo']['tmp_name'];
$Archivo = fopen($Ruta, 'r');

if ($Archivo !== false) {
    // Iniciar una transacción
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO `datos` (`codigo`, `fecha`, `hora`, `filler1`, `filler2`, `filler3`, `filler4`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(array('error' => $conn->error));
        exit;
    }

    // Bind parameters
    $stmt->bind_param('sssssss', $codigo, $fecha, $hora, $filler1, $filler2, $filler3, $filler4);

    // Leer el archivo línea por línea
    while (($Fila = fgets($Archivo)) !== false) {
        $codigo = trim(substr($Fila, 0, 10)); // Toma los datos desde el punto 0 hasta 10 caracteres despues
        $datetime = trim(substr($Fila, 12, 18)); // Toma los datos desde el punto 12 hasta 18 caracteres despues
        $filler1 = trim(substr($Fila, 30, 1)); // Toma los datos desde el punto 30 hasta 1 caracteres despues
        $filler2 = trim(substr($Fila, 32, 2)); // Toma los datos desde el punto 32 hasta 2 caracteres despues
        $filler3 = trim(substr($Fila, 34, 2)); // Toma los datos desde el punto 34 hasta 2 caracteres despues
        $filler4 = trim(substr($Fila, 36, 3)); // Toma los datos desde el punto 36 hasta 3 caracteres despues

        // Separar fecha y hora
        list($fecha, $hora) = explode(' ', $datetime);

        // Ejecutar la consulta preparada
        $stmt->execute();
    }

    fclose($Archivo);

    // Commit the transaction
    if ($stmt->errno === 0) {
        mysqli_commit($conn);
        echo json_encode(array('success' => 'La inserción fue grabada con éxito.'));
    } else {
        mysqli_rollback($conn);
        echo json_encode(array('error' => $stmt->error));
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo json_encode(array('error' => 'No se pudo abrir el archivo.'));
}
