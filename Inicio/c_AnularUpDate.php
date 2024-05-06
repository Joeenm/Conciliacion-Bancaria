<?php
include 'db-conciliacion.php';

// Verificar si se recibieron los datos necesarios
if (isset($_POST['numero_cheque']) && isset($_POST['objeto-1']) && isset($_POST['Objeto-2'])) {
    // Obtener y limpiar los datos recibidos
    $numeroCK = trim($_POST['numero_cheque']);
    $Fecha_Anulado = trim($_POST['objeto-1']);
    $Detalle_Anulado = trim($_POST['Objeto-2']);

    // Verificar que objeto-1 y Objeto-2 no estén vacíos
    if (!empty($Fecha_Anulado) && !empty($Detalle_Anulado)) {
        // Consultar la fecha del cheque a anular
        global $conn;
        $check_date_query = mysqli_query($conn, "SELECT fecha FROM cheques WHERE numero_cheque='$numeroCK'");
        $row = mysqli_fetch_assoc($check_date_query);
        $fecha_cheque = $row['fecha'];

        // Verificar que se encontró la fecha del cheque
        if ($row && !empty($fecha_cheque)) {
            // Convertir las fechas a formato Unix timestamp para comparar
            $timestamp_anulado = strtotime($Fecha_Anulado);
            $timestamp_cheque = strtotime($fecha_cheque);

            // Verificar que la fecha de anulación no sea mayor a la fecha del cheque
            if ($timestamp_anulado >= $timestamp_cheque) {
                // Realizar la actualización en la base de datos
                $sql = mysqli_query($conn, "UPDATE cheques SET fecha_anulado='$Fecha_Anulado', detalle_anulado='$Detalle_Anulado' WHERE numero_cheque='$numeroCK'");
                
                if ($sql) {
                    // Si la actualización se realizó correctamente, enviar mensaje de éxito
                    echo json_encode(array('success' => 'Cheque anulado con éxito.'));
                } else {
                    // Si hubo un error en la actualización, enviar mensaje de error
                    echo json_encode(array('error' => 'Error al anular el cheque.'));
                }
            } else {
                // Si la fecha de anulación es mayor a la fecha del cheque, enviar mensaje de error
                echo json_encode(array('error' => 'Fecha de anulación incorrecta. No puedes anular un cheque antes de su fecha de creación.'));
            }
        } else {
            // Si no se encontró la fecha del cheque, enviar mensaje de error
            echo json_encode(array('error' => 'No se encontró la fecha del cheque.'));
        }
    } else {
        // Si objeto-1 o Objeto-2 están vacíos, enviar mensaje de error
        echo json_encode(array('error' => 'Debe añadir una fecha y una descripción de Anulación.'));
    }
} else {
    // Si no se recibieron todos los datos necesarios, enviar mensaje de error
    echo json_encode(array('error' => 'Faltan datos para anular el cheque.'));
}
?>