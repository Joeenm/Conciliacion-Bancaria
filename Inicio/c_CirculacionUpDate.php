<?php
include 'db-conciliacion.php';

// Verificar si se recibieron los datos necesarios y si objeto-1 no está vacío
if (isset($_POST['numero_cheque'], $_POST['objeto-1']) && !empty($_POST['numero_cheque']) && !empty($_POST['objeto-1'])) {
    // Obtener y limpiar los datos recibidos
    $numeroCK = trim($_POST['numero_cheque']);
    $Fecha_Circulacion = trim($_POST['objeto-1']);

    // Consultar la fecha del cheque en la base de datos
    global $conn;
    $check_date_query = mysqli_query($conn, "SELECT fecha FROM cheques WHERE numero_cheque='$numeroCK'");
    $row = mysqli_fetch_assoc($check_date_query);
    $fecha_cheque = $row['fecha'];

    // Verificar que se encontró la fecha del cheque
    if ($row && !empty($fecha_cheque)) {
        // Convertir las fechas a formato Unix timestamp para comparar
        $fecha_cheque_timestamp = strtotime($fecha_cheque);
        $fecha_circulacion_timestamp = strtotime($Fecha_Circulacion);

        // Verificar que la fecha de circulación no sea mayor a la fecha del cheque
        if ($fecha_circulacion_timestamp >= $fecha_cheque_timestamp) {
            // Realizar la actualización en la base de datos si la comparación es válida
            $sql = mysqli_query($conn, "UPDATE cheques SET fecha_circulacion='$Fecha_Circulacion' WHERE numero_cheque='$numeroCK'");
            
            if ($sql) {
                // Si la actualización se realizó correctamente, enviar mensaje de éxito
                echo json_encode(array('success' => 'Cheque sacado de circulación con éxito.'));
            } else {
                // Si hubo un error en la actualización, enviar mensaje de error
                echo json_encode(array('error' => 'Error al sacar de circulación el cheque.'));
            }
        } else {
            // Si la fecha de circulación es menor a la fecha del cheque, enviar mensaje de error
            echo json_encode(array('error' => 'Fecha de circulación incorrecta. No puedes sacar de circulación un cheque antes de su fecha de emisión.'));
        }
    } else {
        // Si no se encontró la fecha del cheque, enviar mensaje de error
        echo json_encode(array('error' => 'No se encontró la fecha del cheque.'));
    }
} else {
    // Si no se recibieron todos los datos necesarios o objeto-1 está vacío, enviar mensaje de error
    echo json_encode(array('error' => 'Faltan datos para sacar de circulación el cheque.'));
}
?>