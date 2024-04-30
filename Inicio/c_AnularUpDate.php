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
        // Realizar la actualización en la base de datos
        global $conn;
        $sql = mysqli_query($conn, "UPDATE cheques SET fecha_anulado='$Fecha_Anulado', detalle_anulado='$Detalle_Anulado' WHERE numero_cheque='$numeroCK'");
        
        if ($sql) {
            // Si la actualización se realizó correctamente, enviar mensaje de éxito
            echo json_encode(array('success' => 'Cheque anulado con éxito'));
        } else {
            // Si hubo un error en la actualización, enviar mensaje de error
            echo json_encode(array('error' => 'Error al anular el cheque'));
        }
    } else {
        // Si objeto-1 o Objeto-2 están vacíos, enviar mensaje de error
        echo json_encode(array('error' => 'Debe añadir una fecha y una descripción de Anulación'));
    }
} else {
    // Si no se recibieron todos los datos necesarios, enviar mensaje de error
    echo json_encode(array('error' => 'Faltan datos para anular el cheque'));
}
?>